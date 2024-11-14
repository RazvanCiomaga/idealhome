<?php

namespace App\Filament\Resources\AgencyResource\Pages;

use App\Console\Commands\SyncAgencies;
use App\Filament\Resources\AgencyResource;
use App\Services\ImobManager;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgencies extends ListRecords
{
    protected static string $resource = AgencyResource::class;

    public static bool $wasSynced = false;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync_agents')
                ->label(fn () => self::$wasSynced ? label('Sincrionizat') : label('Sincronizare'))
                ->icon(fn () => self::$wasSynced ? 'heroicon-o-check' : 'heroicon-o-arrow-path')
                ->action(function () {
                    SyncAgencies::dispatch(new ImobManager());
                    self::$wasSynced = !self::$wasSynced;
                }),
        ];
    }
}
