<?php

namespace App\Filament\Customer\Pages;

use Filament\Pages\Page;
use App\Models\MsPhotocard;

class ProductDetail extends Page
{
    protected string $view = 'filament.customer.pages.product-detail';
    
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Detail Produk';
    protected static ?string $slug = 'product-detail';

    public ?MsPhotocard $product = null;

    public function mount()
    {
        $id = request()->query('id');

        if (!$id) {
            abort(404);
        }

        $this->product = MsPhotocard::findOrFail($id);
        
        $this->heading = $this->product->nama_pc;
    }
}