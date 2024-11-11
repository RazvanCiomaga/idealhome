<?php

namespace App\Filament\Resources\PossibleClientResource\Pages;

use App\Filament\Resources\PossibleClientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPossibleClient extends EditRecord
{
    protected static string $resource = PossibleClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
