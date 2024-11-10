<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstateResource\Pages;
use App\Filament\Resources\EstateResource\RelationManagers;
use App\Models\Estate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstateResource extends Resource
{
    protected static ?string $model = Estate::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Section::make('Detalii')
                        ->schema([
                            Forms\Components\Select::make('agent_id')
                                ->label('Agent')
                                ->relationship('agent', 'name', fn ($query) => $query->whereNotNull('imobmanager_id')),
                            Forms\Components\TextInput::make('title')
                                ->label('Titlu')
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('description')
                                ->label('Descriere')
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('city')
                                ->label('Oras')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('zone')
                                ->label('Zona')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('county')
                                ->label('Judet')
                                ->maxLength(255),
                        ])
                        ->columns(2)
                        ->columnSpan(3),
                    Forms\Components\Section::make('Caracteristici')
                        ->schema([
                            Forms\Components\Select::make('properties')
                                ->label('Caracteristici')
                                ->multiple()
                                ->relationship('properties', 'name')
                                ->preload()
                                ->searchable(),
                        ]),
                    Forms\Components\Section::make('Preturi')
                        ->schema([
                            Forms\Components\TextInput::make('sale_price')
                                ->prefix('€')
                                ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.'))
                                ->mask(RawJs::make(
                                    <<<'JS'
                                        $money($input, ',', '.', 2)
                                        JS
                                ))
                                ->label('Pret vanzare'),
                            Forms\Components\TextInput::make('rent_price')
                                ->label('Pret inchiriere')
                                ->prefix('€')
                                ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.'))
                                ->mask(RawJs::make(
                                    <<<'JS'
                                        $money($input, ',', '.', 2)
                                        JS
                                )),
                            Forms\Components\TextInput::make('rent_price_sqm')
                                ->label('Pret inchiriere pe mp')
                                ->prefix('€')
                                ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.'))
                                ->mask(RawJs::make(
                                    <<<'JS'
                                        $money($input, ',', '.', 2)
                                        JS
                                )),
                        ])
                        ->columns(1)
                        ->columnSpan(1),
                    Forms\Components\Section::make('Caracteristici')
                        ->schema([
                            Forms\Components\TextInput::make('rooms')
                                ->label('Camere')
                                ->numeric(),
                            Forms\Components\TextInput::make('bathrooms')
                                ->label('Bai')
                                ->numeric(),
                            Forms\Components\TextInput::make('floor')
                                ->label('Etaj')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('max_floor')
                                ->label('Etaj maxim')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('floor_formatted')
                                ->label('Etaj formatat')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('area')
                                ->label('Suprafata totala')
                                ->numeric(),
                            Forms\Components\TextInput::make('usable_area')
                                ->label('Suprafata utila')
                                ->numeric(),
                            Forms\Components\TextInput::make('total_area')
                                ->label('Suprafata totala')
                                ->numeric(),
                            Forms\Components\TextInput::make('land_area')
                                ->label('Suprafata teren')
                                ->numeric(),
                            Forms\Components\TextInput::make('room_entrances')
                                ->label('Intrari')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('construction_year')
                                ->label('An constructie')
                                ->numeric(),
                            Forms\Components\TextInput::make('energy_class')
                                ->label('Clasa energetica')
                                ->maxLength(255),
                        ])
                        ->columns(2)
                        ->columnSpan(2),
            ])->columns(3);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agent.name')
                    ->label('Agent'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titlu')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Oraș')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zone')
                    ->label('Zonă')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('Preț Vânzare')
                    ->prefix('€')
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rent_price')
                    ->label('Preț Închiriere')
                    ->prefix('€')
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rent_price_sqm')
                    ->label('Preț Închiriere mp')
                    ->prefix('€')
                    ->formatStateUsing(fn($state) => number_format($state, 2, ',', '.'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_date')
                    ->label('Data Publicare')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('agent_id')
                    ->label('Agent')
                    ->relationship('agent', 'name', fn (Builder $query) => $query->whereNotNull('imobmanager_id'))
                    ->searchable()
                    ->preload()
                    ->optionsLimit(20),
                Tables\Filters\TernaryFilter::make('offer_type')
                    ->label('Tip Ofertă')
                    ->placeholder('Tip Ofertă')
                    ->trueLabel('Vanzare')
                    ->falseLabel('Inchiriere')
                    ->queries(
                        true: fn (Builder $query) => $query->where('sale_price', '>', 0)->where('rent_price', '=', 0),
                        false: fn (Builder $query) => $query->where('sale_price', '=', 0)->where('rent_price', '>', 0),
                        blank: fn (Builder $query) => $query,
                    )

            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstates::route('/'),
            'create' => Pages\CreateEstate::route('/create'),
            'edit' => Pages\EditEstate::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Proprietate';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Proprietati';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }
}
