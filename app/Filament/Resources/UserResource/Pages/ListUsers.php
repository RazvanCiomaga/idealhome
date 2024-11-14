<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Console\Commands\SyncAgents;
use App\Filament\Resources\UserResource;
use App\Services\ImobManager;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public static bool $wasSynced = false;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync_agents')
                ->label(fn () => self::$wasSynced ? label('Sincrionizat') : label('Sincronizare'))
                ->icon(fn () => self::$wasSynced ? 'heroicon-o-check' : 'heroicon-o-arrow-path')
                ->action(function () {
                    SyncAgents::dispatch(new ImobManager());
                    self::$wasSynced = !self::$wasSynced;
                }),
        ];
    }
}
