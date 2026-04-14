<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 1;

    // ─── Labels e navigazione ────────────────────────────────────────────────

    public static function getLabel(): string
    {
        return __('companies.label');
    }

    public static function getPluralLabel(): string
    {
        return __('companies.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('companies.navigation.group');
    }

    // ─── Form (create + edit) ─────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([

            Section::make(__('companies.sections.info'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('companies.fields.name'))
                        ->required()
                        ->maxLength(255),

                    TextInput::make('vat_number')
                        ->label(__('companies.fields.vat_number'))
                        ->maxLength(50)
                        ->unique(Company::class, 'vat_number', ignoreRecord: true)
                        ->nullable(),

                    TextInput::make('email')
                        ->label(__('companies.fields.email'))
                        ->email()
                        ->maxLength(255)
                        ->nullable(),

                    TextInput::make('phone')
                        ->label(__('companies.fields.phone'))
                        ->tel()
                        ->maxLength(50)
                        ->nullable(),
                ])
                ->columns(2),

            Section::make(__('companies.sections.logo'))
                ->schema([
                    FileUpload::make('logo_path')
                        ->label(__('companies.fields.logo'))
                        ->image()
                        ->disk('public')
                        ->directory('logos')
                        ->imagePreviewHeight('80')
                        ->maxSize(2048)
                        ->nullable(),
                ]),
        ]);
    }

    // ─── Table (lista) ────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label(__('companies.fields.logo'))
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn (): string => 'https://ui-avatars.com/api/?name=&background=e5e7eb&color=9ca3af&size=40')
                    ->size(36),

                TextColumn::make('name')
                    ->label(__('companies.fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vat_number')
                    ->label(__('companies.fields.vat_number'))
                    ->searchable()
                    ->default('-'),

                TextColumn::make('email')
                    ->label(__('companies.fields.email'))
                    ->searchable()
                    ->default('-'),

                TextColumn::make('phone')
                    ->label(__('companies.fields.phone'))
                    ->default('-'),

                TextColumn::make('users_count')
                    ->label(__('companies.fields.users_count'))
                    ->counts('users')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label(__('companies.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index'  => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit'   => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
