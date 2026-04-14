<?php

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    // ─── Labels e navigazione ────────────────────────────────────────────────

    public static function getLabel(): string
    {
        return __('users.label');
    }

    public static function getPluralLabel(): string
    {
        return __('users.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('users.navigation.group');
    }

    // ─── Form (create + edit) ─────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([

            Section::make(__('users.sections.personal'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('users.fields.name'))
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label(__('users.fields.email'))
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(User::class, 'email', ignoreRecord: true),

                    TextInput::make('password')
                        ->label(__('users.fields.password'))
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->minLength(8)
                        // Non inviare il campo se lasciato vuoto in modifica
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->hint(fn (string $operation): string => $operation === 'edit'
                            ? __('users.fields.password_hint_edit')
                            : ''
                        ),

                    TextInput::make('password_confirmation')
                        ->label(__('users.fields.password_confirmation'))
                        ->password()
                        ->revealable()
                        ->same('password')
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(false),
                ])
                ->columns(2),

            Section::make(__('users.sections.access'))
                ->schema([
                    Select::make('role')
                        ->label(__('users.fields.role'))
                        ->options(
                            collect(UserRole::cases())
                                ->mapWithKeys(fn ($r) => [$r->value => $r->label()])
                                ->toArray()
                        )
                        ->required()
                        ->live(), // Aggiorna reattivamente can_view_company_tickets

                    Select::make('company_id')
                        ->label(__('users.fields.company'))
                        ->relationship('company', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Toggle::make('can_view_company_tickets')
                        ->label(__('users.fields.can_view_company_tickets'))
                        ->default(false)
                        // Visibile solo se il ruolo selezionato è 'client'
                        ->visible(fn (Get $get): bool => $get('role') === UserRole::Client->value)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    // ─── Table (lista) ────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('users.fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('users.fields.email'))
                    ->searchable(),

                TextColumn::make('role')
                    ->label(__('users.fields.role'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'administrator' => 'danger',
                        'supervisor'    => 'warning',
                        'operator'      => 'info',
                        'client'        => 'success',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => UserRole::from($state)->label()),

                TextColumn::make('company.name')
                    ->label(__('users.fields.company'))
                    ->default('-')
                    ->sortable(),

                IconColumn::make('can_view_company_tickets')
                    ->label(__('users.fields.can_view_company_tickets'))
                    ->boolean()
                    ->hidden(fn (): bool => ! auth()->user()->isAdministrator()),

                TextColumn::make('created_at')
                    ->label(__('users.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label(__('users.filters.role'))
                    ->options(
                        collect(UserRole::cases())
                            ->mapWithKeys(fn ($r) => [$r->value => $r->label()])
                            ->toArray()
                    ),

                SelectFilter::make('company_id')
                    ->label(__('users.filters.company'))
                    ->relationship('company', 'name'),
            ])
            ->defaultSort('name')
            ->actions([
                EditAction::make()
                    ->visible(fn (User $record): bool => auth()->user()->can('update', $record)),
                DeleteAction::make()
                    ->visible(fn (User $record): bool => auth()->user()->can('delete', $record)),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
