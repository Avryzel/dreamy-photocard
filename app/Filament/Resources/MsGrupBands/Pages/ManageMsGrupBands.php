<?php

namespace App\Filament\Resources\MsGrupBands\Pages;

use App\Filament\Resources\MsGrupBands\MsGrupBandResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMsGrupBands extends ManageRecords
{
    protected static string $resource = MsGrupBandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
