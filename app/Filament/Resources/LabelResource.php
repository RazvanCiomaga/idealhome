<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabelResource\Pages;
use App\Filament\Resources\LabelResource\RelationManagers;
use App\Models\Label;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabelResource extends Resource
{
    protected static ?string $model = Label::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->label('Valoare originala')
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->disabled()
                            ->label('Valoare originala'),
                        Forms\Components\Textarea::make('label')
                            ->rows(10)
                            ->required()
                            ->label('Valoare afisata')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make()
                    ->label('Traduceri')
                    ->schema([
                        Forms\Components\Repeater::make('translations')
                            ->relationship('translations')
                            ->label('Traduceri')
                            ->schema([
                                Forms\Components\Textarea::make('value')
                                    ->label('Traducere')
                                    ->required(),
                                Forms\Components\Select::make('locale')
                                    ->required()
                                    ->label('Limbaj')
                                    ->options([
                                        'en' => 'English',
                                        'ro' => 'Romana',
                                    ])
                                    ->default('en'),
                            ])->columnSpanFull()
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('Valoare originala')
                    ->searchable(),
                Tables\Columns\TextColumn::make('label')
                    ->label('Valoare afisata')
                    ->searchable(),
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
            'index' => Pages\ListLabels::route('/'),
            'create' => Pages\CreateLabel::route('/create'),
            'edit' => Pages\EditLabel::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Traducere';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Traduceri & text';
    }
}
