<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PossibleClientResource\Pages;
use App\Filament\Resources\PossibleClientResource\RelationManagers;
use App\Models\PossibleClient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PossibleClientResource extends Resource
{
    protected static ?string $model = PossibleClient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nume')
                            ->readOnly()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->readOnly()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Nr. telefon')
                            ->readOnly()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('message')
                            ->label('Mesaj')
                            ->rows(5)
                            ->readOnly(),
                    ]),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estates.agent.name')
                    ->label('Agent'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nume')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nr. telefon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('agent')
                    ->label('Agent')
                    ->form([
                        Forms\Components\Select::make('agent')
                            ->label('Agent')
                            ->options(fn () => User::query()->whereNotNull('imobmanager_id')->pluck('name', 'id')->toArray()),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['agent'], function (Builder $query, $agent) {
                                $query->whereHas('estates', function (Builder $query) use ($agent) {
                                    $query->where('agent_id', $agent);
                                });
                            });
                    }),
            ],layout: Tables\Enums\FiltersLayout::AboveContent)
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
            RelationManagers\EstatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPossibleClients::route('/'),
            'create' => Pages\CreatePossibleClient::route('/create'),
            'edit' => Pages\EditPossibleClient::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Posibil client';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Posibili clienti';
    }
}
