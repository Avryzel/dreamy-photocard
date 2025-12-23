<?php

namespace App\Filament\Widgets;

use App\Models\TrxPesanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PenjualanStats extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Pesanan Baru', TrxPesanan::where('status_pesanan', 'PERMINTAAN')->count())
                ->description('Segera proses pesanan ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format(TrxPesanan::where('status_pesanan', 'SELESAI')->sum('total_harga'), 0, ',', '.'))
                ->description('Total dari pesanan selesai')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Pelanggan', \App\Models\User::where('role', 'pelanggan')->count())
                ->description('User terdaftar di sistem')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}