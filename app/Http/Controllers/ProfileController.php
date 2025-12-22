<?php

namespace App\Http\Controllers;

use App\Models\MsUser;
use App\Models\TrxPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = TrxPesanan::with('details.photocard')
                    ->where('idUser', $user->idUser) 
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('dreamy-store.profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255', 
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->username = $request->username; 

        if ($request->hasFile('avatar')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            
            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}