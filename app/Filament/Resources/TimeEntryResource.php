<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeEntryResource\Pages;
use App\Models\TimeEntry;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TimeEntryResource extends Resource
{
    protected static ?string $model = TimeEntry::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static ?int $navigationSort = 2;

    // ─── Labels e navigazione ────────────────────────────────────────────────

    public static function getLabel(): string
    {
        return __('time_entries.label');
    }

    public static function getPluralLabel(): string
    {
        return __('time_entries.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('time_entries.navigation.group');
    }

    // ─── Scoping per ruolo ────────────────────────────────────────────────────

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();

        // Operator vede solo le proprie registrazioni
        if ($user?->isOperator()) {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }

    // ─── Form (create + edit) ─────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        $isOperator = auth()->user()?->isOperator();

        return $schema->schema([
            Section::make(__('time_entries.label'))
                ->schema([
                    Select::make('ticket_id')
                        ->label(__('time_entries.fields.ticket'))
                        ->relationship('ticket', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('user_id')
                        ->label(__('time_entries.fields.user'))
                        ->relationship('user', 'name', fn (Builder $query) => $query->whereIn('role', ['administrator', 'supervisor', 'operator']))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->hidden($isOperator)
                        ->default(fn (): int => auth()->id()),

                    TextInput::make('minutes_spent')
                        ->label(__('time_entries.fields.minutes_spent'))
                        ->numeric()
                        ->minValue(1)
                        ->required()
                        ->suffix('min'),

                    Textarea::make('notes')
                        ->label(__('time_entries.fields.notes'))
                        ->rows(3)
                        ->nullable()
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    // ─── Table (lista) ────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        $isOperator = auth()->user()?->isOperator();

        $filters = [
            SelectFilter::make('ticket_id')
                ->label(__('time_entries.filters.ticket'))
                ->relationship('ticket', 'title')
                ->searchable()
                ->preload(),
        ];

        if (! $isOperator) {
            $filters[] = SelectFilter::make('user_id')
                ->label(__('time_entries.filters.user'))
                ->relationship('user', 'name')
                ->searchable()
                ->preload();
        }

        return $table
            ->columns([
                TextColumn::make('ticket.title')
                    ->label(__('time_entries.fields.ticket'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label(__('time_entries.fields.user'))
                    ->sortable()
                    ->hidden($isOperator),

                TextColumn::make('minutes_spent')
                    ->label(__('time_entries.fields.minutes_spent'))
                    ->formatStateUsing(fn (TimeEntry $record): string => $record->formattedDuration())
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label(__('time_entries.fields.notes'))
                    ->limit(60)
                    ->default('-'),

                TextColumn::make('created_at')
                    ->label(__('time_entries.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome')
                    ->sortable(),
            ])
            ->filters($filters)
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make()
                    ->visible(fn (TimeEntry $record): bool => auth()->user()->can('update', $record)),
                DeleteAction::make()
                    ->visible(fn (TimeEntry $record): bool => auth()->user()->can('delete', $record)),
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
            'index'  => Pages\ListTimeEntries::route('/'),
            'create' => Pages\CreateTimeEntry::route('/create'),
            'edit'   => Pages\EditTimeEntry::route('/{record}/edit'),
        ];
    }
}
