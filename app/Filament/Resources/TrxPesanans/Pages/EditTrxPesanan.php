<?php

namespace App\Filament\Resources\TrxPesanans\Pages;

use App\Filament\Resources\TrxPesanans\TrxPesananResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrxPesanan extends EditRecord
{
    protected static string $resource = TrxPesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
