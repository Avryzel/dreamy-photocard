<?php

namespace App\Http\Controllers;

use App\Models\MsPhotocard;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = MsPhotocard::orderBy('created_at', 'desc')->take(4)->get();
        $bestSellers = MsPhotocard::inRandomOrder()->take(4)->get();

        return view('dreamy-store.dashboard', compact('latestProducts', 'bestSellers'));
    }
}