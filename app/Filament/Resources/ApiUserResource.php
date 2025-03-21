<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiUserResource\Pages;
use App\Filament\Resources\ApiUserResource\RelationManagers;
use App\Models\ApiUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiUserResource extends Resource
{
    protected static ?string $model = ApiUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic')
                    ->schema([
                        Forms\Components\TextInput::make('name'),
                        Forms\Components\TextInput::make('client_id')->disabled(),
                        Forms\Components\TextInput::make('client_secret')->disabled(),
                        Forms\Components\Toggle::make('is_active'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('client_id'),
                Tables\Columns\TextColumn::make('client_secret'),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListApiUsers::route('/'),
            'create' => Pages\CreateApiUser::route('/create'),
            'edit' => Pages\EditApiUser::route('/{record}/edit'),
        ];
    }
}
