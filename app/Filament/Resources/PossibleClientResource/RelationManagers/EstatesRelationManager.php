<?php

namespace App\Filament\Resources\PossibleClientResource\RelationManagers;

use App\Filament\Resources\EstateResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstatesRelationManager extends RelationManager
{
    protected static string $relationship = 'estates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               //
            ]);
    }

    public function table(Table $table): Table
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
            ])
            ->bulkActions([
            ])
            ->recordUrl(fn ($record) => EstateResource::getUrl('edit', ['record' => $record]));
    }

    /**
     * @param Model $ownerRecord
     * @param string $pageClass
     * @return string
     */
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Proprietati de interes';
    }
}
