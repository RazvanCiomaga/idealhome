<?php

namespace App\Filament\Resources\EstateResource\Pages;

use App\Console\Commands\SyncEstates;
use App\Filament\Resources\EstateResource;
use App\Services\ImobManager;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstates extends ListRecords
{
    protected static string $resource = EstateResource::class;

    public static bool $wasSynced = false;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync_agents')
                ->label(fn () => self::$wasSynced ? label('Sincrionizat') : label('Sincronizare'))
                ->icon(fn () => self::$wasSynced ? 'heroicon-o-check' : 'heroicon-o-arrow-path')
                ->action(function () {
                    SyncEstates::dispatch(new ImobManager());
                    self::$wasSynced = !self::$wasSynced;
                }),
        ];
    }
}
