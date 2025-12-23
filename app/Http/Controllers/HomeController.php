<?php

namespace App\Http\Controllers;

use App\Models\MsPhotocard;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = MsPhotocard::latest()->paginate(10); 

        $bestSellers = MsPhotocard::inRandomOrder()->take(4)->get();

        return view('dreamy-store.dashboard', compact('latestProducts', 'bestSellers'));
    }
}