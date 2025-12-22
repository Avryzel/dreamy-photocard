<?php

namespace App\Filament\Resources\TrxPesanans\Pages;

use App\Filament\Resources\TrxPesanans\TrxPesananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrxPesanan extends EditRecord
{
    protected static string $resource = TrxPesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}