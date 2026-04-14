<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
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

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    // ─── Labels e navigazione ────────────────────────────────────────────────

    public static function getLabel(): string
    {
        return __('departments.label');
    }

    public static function getPluralLabel(): string
    {
        return __('departments.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('departments.navigation.group');
    }

    // ─── Form (create + edit) ─────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('departments.label'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('departments.fields.name'))
                        ->required()
                        ->maxLength(255)
                        ->unique(Department::class, 'name', ignoreRecord: true)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    // ─── Table (lista) ────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('departments.fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tickets_count')
                    ->label('Ticket')
                    ->counts('tickets')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label(__('departments.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->actions([
                EditAction::make()
                    ->visible(fn (Department $record): bool => auth()->user()->can('update', $record)),
                DeleteAction::make()
                    ->visible(fn (Department $record): bool => auth()->user()->can('delete', $record)),
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
            'index'  => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit'   => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
