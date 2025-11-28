<?php

namespace App\Filament\Resources\MsPhotocards\Pages;

use App\Filament\Resources\MsPhotocards\MsPhotocardResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMsPhotocards extends ManageRecords
{
    protected static string $resource = MsPhotocardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}