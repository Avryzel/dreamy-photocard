<?php

namespace App\Filament\Resources\TrxPesanans\Pages;

use App\Filament\Resources\TrxPesanans\TrxPesananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrxPesanans extends ListRecords
{
    protected static string $resource = TrxPesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
