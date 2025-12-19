<?php

namespace App\Filament\Customer\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\MsPhotocard; 

class Dashboard extends BaseDashboard {
    protected static ?string $title = 'Dreamy Photocard';

    protected static ?string $slug = '/';

    protected ?string $heading = ''; 

    public function getView(): string
    {
        return 'filament.customer.pages.dashboard';
    }

    protected function getViewData(): array
    {
        return [
            'latestProducts' => MsPhotocard::latest()->take(4)->get(),
            
            'bestSellers' => MsPhotocard::inRandomOrder()->take(4)->get(),
        ];
    }
}