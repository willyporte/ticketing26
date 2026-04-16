<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Models\Plan;
use App\Models\Subscription;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 3;

    // ─── Labels e navigazione ────────────────────────────────────────────────

    public static function getLabel(): string
    {
        return __('subscriptions.label');
    }

    public static function getPluralLabel(): string
    {
        return __('subscriptions.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('subscriptions.navigation.group');
    }

    // ─── Form (create + edit) ─────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('subscriptions.label'))
                ->schema([
                    Select::make('company_id')
                        ->label(__('subscriptions.fields.company'))
                        ->relationship('company', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('plan_id')
                        ->label(__('subscriptions.fields.plan'))
                        ->options(Plan::orderBy('name')->pluck('name', 'id'))
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                            if (! $state) {
                                return;
                            }

                            $plan = Plan::find($state);

                            if (! $plan) {
                                return;
                            }

                            // Auto-popola i minuti residui con i minuti totali del piano
                            $set('minutes_remaining', $plan->total_minutes);

                            // Auto-calcola expires_at se starts_at è già impostato
                            $startsAt = $get('starts_at');
                            if ($startsAt) {
                                $set('expires_at', Carbon::parse($startsAt)->addDays($plan->validity_days)->format('Y-m-d'));
                            }
                        }),

                    DatePicker::make('starts_at')
                        ->label(__('subscriptions.fields.starts_at'))
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                            if (! $state) {
                                return;
                            }

                            $planId = $get('plan_id');
                            if (! $planId) {
                                return;
                            }

                            $plan = Plan::find($planId);
                            if ($plan) {
                                $set('expires_at', Carbon::parse($state)->addDays($plan->validity_days)->format('Y-m-d'));
                            }
                        })
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    DatePicker::make('expires_at')
                        ->label(__('subscriptions.fields.expires_at'))
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    TextInput::make('minutes_remaining')
                        ->label(__('subscriptions.fields.minutes_remaining'))
                        ->numeric()
                        ->required()
                        ->suffix('min'),
                ])
                ->columns(2),
        ]);
    }

    // ─── Table (lista) ────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->label(__('subscriptions.fields.company'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('plan.name')
                    ->label(__('subscriptions.fields.plan'))
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('minutes_remaining')
                    ->label(__('subscriptions.fields.minutes_remaining'))
                    ->badge()
                    ->icon(fn (Subscription $record): string => $record->isBelowWarningThreshold()
                        ? 'heroicon-o-exclamation-triangle'
                        : 'heroicon-o-check-circle'
                    )
                    ->color(fn (Subscription $record): string => match (true) {
                        $record->minutes_remaining <= 0        => 'danger',
                        $record->isBelowWarningThreshold()     => 'warning',
                        default                                => 'success',
                    })
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label(__('subscriptions.fields.starts_at'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label(__('subscriptions.fields.expires_at'))
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn (Subscription $record): string => $record->isActive() ? 'success' : 'danger'),

                IconColumn::make('is_active')
                    ->label(__('subscriptions.status.active'))
                    ->boolean()
                    ->getStateUsing(fn (Subscription $record): bool => $record->isActive())
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                SelectFilter::make('company_id')
                    ->label(__('subscriptions.fields.company'))
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'active'  => __('subscriptions.status.active'),
                        'expired' => __('subscriptions.status.expired'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => match ($data['value'] ?? null) {
                        'active'  => $query->active(),
                        'expired' => $query->whereDate('expires_at', '<', Carbon::today()),
                        default   => $query,
                    }),
            ])
            ->defaultSort('expires_at')
            ->actions([
                EditAction::make()
                    ->visible(fn (Subscription $record): bool => auth()->user()->can('update', $record)),
                DeleteAction::make()
                    ->visible(fn (Subscription $record): bool => auth()->user()->can('delete', $record)),
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
            'index'  => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit'   => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
