<?php

namespace App\Filament\Resources;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 1;

    // ─── Labels e navigazione ────────────────────────────────────────────────

    public static function getLabel(): string
    {
        return __('tickets.label');
    }

    public static function getPluralLabel(): string
    {
        return __('tickets.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('tickets.navigation.group');
    }

    // ─── Query base: scoped per ruolo ─────────────────────────────────────────

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();

        if ($user?->isClient()) {
            if ($user->can_view_company_tickets) {
                // Vede tutti i ticket della propria azienda
                return $query->where('company_id', $user->company_id);
            }
            // Vede solo i propri ticket
            return $query->where('created_by', $user->id);
        }

        return $query;
    }

    // ─── Form (create + edit) ─────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([

            Section::make(__('tickets.sections.details'))
                ->schema([
                    TextInput::make('title')
                        ->label(__('tickets.fields.title'))
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->label(__('tickets.fields.description'))
                        ->required()
                        ->rows(5)
                        ->columnSpanFull(),

                    Select::make('priority')
                        ->label(__('tickets.fields.priority'))
                        ->options(
                            collect(TicketPriority::cases())
                                ->mapWithKeys(fn ($p) => [$p->value => $p->label()])
                                ->toArray()
                        )
                        ->default(TicketPriority::Medium->value)
                        ->required(),

                    // Nascosto per il Client — viene impostato server-side in CreateTicket
                    Select::make('company_id')
                        ->label(__('tickets.fields.company'))
                        ->relationship('company', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->hidden(fn (): bool => auth()->user()->isClient()),

                    Select::make('department_id')
                        ->label(__('tickets.fields.department'))
                        ->relationship('department', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    // Allegati — solo in creazione, in edit si gestiscono dalla pagina View
                    FileUpload::make('attachment_paths')
                        ->label(__('tickets.sections.attachments'))
                        ->multiple()
                        ->maxFiles(10)
                        ->maxSize(10240) // 10 MB in KB
                        ->acceptedFileTypes([
                            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/plain',
                            'application/zip',
                        ])
                        ->disk('local')
                        ->directory('attachments/temp')
                        ->visibility('private')
                        ->storeFileNamesIn('attachment_names')
                        ->columnSpanFull()
                        ->hidden(fn (string $operation): bool => $operation !== 'create'),
                ])
                ->columns(2),

            // Sezione visibile solo allo staff (Operator, Supervisor, Admin)
            Section::make(__('tickets.sections.assignment'))
                ->schema([
                    Select::make('status')
                        ->label(__('tickets.fields.status'))
                        ->options(
                            collect(TicketStatus::cases())
                                ->mapWithKeys(fn ($s) => [$s->value => $s->label()])
                                ->toArray()
                        )
                        ->required()
                        // In creazione lo status è sempre 'open' — impostato server-side
                        ->hidden(fn (string $operation): bool => $operation === 'create'),

                    Select::make('assigned_to')
                        ->label(__('tickets.fields.assigned_to'))
                        ->options(function (): array {
                            $user = auth()->user();
                            // Operator: può assegnare solo a sé stesso
                            if ($user->isOperator()) {
                                return [$user->id => $user->name];
                            }
                            // Admin/Supervisor: tutti gli operator e supervisor
                            return User::whereIn('role', ['operator', 'supervisor'])
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->toArray();
                        })
                        ->nullable()
                        ->searchable()
                        ->preload(),
                ])
                ->hidden(fn (): bool => auth()->user()->isClient())
                ->columns(2),
        ]);
    }

    // ─── Table (lista) ────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        // Costruzione condizionale dei filtri — ->filters() accetta solo array, non closure
        $filters = [
            SelectFilter::make('status')
                ->label(__('tickets.filters.status'))
                ->options(
                    collect(TicketStatus::cases())
                        ->mapWithKeys(fn ($s) => [$s->value => $s->label()])
                        ->toArray()
                ),

            SelectFilter::make('priority')
                ->label(__('tickets.filters.priority'))
                ->options(
                    collect(TicketPriority::cases())
                        ->mapWithKeys(fn ($p) => [$p->value => $p->label()])
                        ->toArray()
                ),

            SelectFilter::make('department_id')
                ->label(__('tickets.filters.department'))
                ->relationship('department', 'name'),
        ];

        // Filtri aggiuntivi per lo staff (admin, supervisor, operator)
        if (! auth()->user()->isClient()) {
            $filters[] = SelectFilter::make('assigned_to')
                ->label(__('tickets.filters.assigned_to'))
                ->options(
                    User::whereIn('role', ['operator', 'supervisor'])
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->toArray()
                );

            $filters[] = SelectFilter::make('company_id')
                ->label(__('tickets.filters.company'))
                ->relationship('company', 'name');
        }

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('tickets.fields.title'))
                    ->searchable()
                    ->limit(50),

                TextColumn::make('status')
                    ->label(__('tickets.fields.status'))
                    ->badge()
                    ->color(fn (TicketStatus $state): string => $state->color())
                    ->formatStateUsing(fn (TicketStatus $state): string => $state->label()),

                TextColumn::make('priority')
                    ->label(__('tickets.fields.priority'))
                    ->badge()
                    ->color(fn (TicketPriority $state): string => $state->color())
                    ->formatStateUsing(fn (TicketPriority $state): string => $state->label()),

                TextColumn::make('company.name')
                    ->label(__('tickets.fields.company'))
                    ->sortable()
                    ->hidden(fn (): bool => auth()->user()->isClient()),

                TextColumn::make('assignee.name')
                    ->label(__('tickets.fields.assigned_to'))
                    ->default('-')
                    ->hidden(fn (): bool => auth()->user()->isClient()),

                TextColumn::make('created_at')
                    ->label(__('tickets.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome')
                    ->sortable(),
            ])
            ->filters($filters)
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn (Ticket $record): string => static::getUrl('view', ['record' => $record]))
            ->actions([
                EditAction::make()
                    ->visible(fn (Ticket $record): bool => auth()->user()->can('update', $record)),
                DeleteAction::make()
                    ->visible(fn (Ticket $record): bool => auth()->user()->can('delete', $record)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()->isAdministrator()),
                ]),
            ]);
    }

    // ─── Pagine ───────────────────────────────────────────────────────────────

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view'   => Pages\ViewTicket::route('/{record}'),
            'edit'   => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
