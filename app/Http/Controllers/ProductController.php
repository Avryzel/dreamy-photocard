<?php

namespace App\Http\Controllers;

use App\Models\MsPhotocard;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = MsPhotocard::findOrFail($id);

        return view('dreamy-store.product-detail', compact('product'));
    }
}