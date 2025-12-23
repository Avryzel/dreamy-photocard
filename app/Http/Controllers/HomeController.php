<?php

namespace App\Http\Controllers;

use App\Models\MsPhotocard;
use App\Models\MsGrupBand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = MsPhotocard::latest()->paginate(10);
        
        $bestSellers = MsPhotocard::inRandomOrder()->take(4)->get();

        $groups = MsGrupBand::orderBy('nama_group', 'asc')->get(); 

        return view('dreamy-store.dashboard', compact('latestProducts', 'bestSellers', 'groups'));
    }
}