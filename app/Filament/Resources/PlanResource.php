<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 2;

    // ─── Labels e navigazione ────────────────────────────────────────────────

    public static function getLabel(): string
    {
        return __('plans.label');
    }

    public static function getPluralLabel(): string
    {
        return __('plans.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('plans.navigation.group');
    }

    // ─── Form (create + edit) ─────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('plans.sections.details'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('plans.fields.name'))
                        ->required()
                        ->maxLength(255)
                        ->unique(Plan::class, 'name', ignoreRecord: true),

                    TextInput::make('price')
                        ->label(__('plans.fields.price'))
                        ->numeric()
                        ->minValue(0)
                        ->step(0.01)
                        ->prefix('€')
                        ->nullable(),

                    TextInput::make('total_minutes')
                        ->label(__('plans.fields.total_minutes'))
                        ->numeric()
                        ->minValue(1)
                        ->required()
                        ->suffix('min'),

                    TextInput::make('validity_days')
                        ->label(__('plans.fields.validity_days'))
                        ->numeric()
                        ->minValue(1)
                        ->required()
                        ->suffix('gg'),
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
                    ->label(__('plans.fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_minutes')
                    ->label(__('plans.fields.total_minutes'))
                    ->formatStateUsing(fn (int $state): string => number_format($state) . ' min')
                    ->sortable(),

                TextColumn::make('validity_days')
                    ->label(__('plans.fields.validity_days'))
                    ->formatStateUsing(fn (int $state): string => $state . ' gg')
                    ->sortable(),

                TextColumn::make('price')
                    ->label(__('plans.fields.price'))
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('subscriptions_count')
                    ->label(__('plans.fields.subscriptions_count'))
                    ->counts('subscriptions')
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label(__('plans.fields.created_at'))
                    ->dateTime('d/m/Y')
                    ->timezone('Europe/Rome')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->actions([
                EditAction::make()
                    ->visible(fn (Plan $record): bool => auth()->user()->can('update', $record)),
                DeleteAction::make()
                    ->visible(fn (Plan $record): bool => auth()->user()->can('delete', $record)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ─── Pagine ───────────────────────────────────────────────────────────────

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit'   => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
