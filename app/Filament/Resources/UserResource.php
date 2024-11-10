<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Filament Shield';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalii')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nume'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->label('Nr. Telefon'),
                        Forms\Components\TextInput::make('position')
                            ->label('Grad'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Parola')
                            ->visible(fn ($record) => !$record),
                        Forms\Components\Textarea::make('description')
                            ->label('Descriere')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('roles')
                            ->label('Roluri')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->columnSpanFull()
                            ->searchable()
                            ->preload(),
                    ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nume')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nr. Telefon')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Grad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roluri'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descriere')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Agent';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Agenti';
    }


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User|null $user */
        $user = auth()->user();

        if ($user && $user->hasRole('super_admin')) {
            return $query;
        }

        if ($user && $user->hasRole('agent')) {
            return $query->where('id', $user->id);
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }
}
