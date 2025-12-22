<?php

namespace App\Http\Controllers;

use App\Models\MsPhotocard;
use App\Models\TrxKeranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = TrxKeranjang::with('photocard')
            ->where('idUser', Auth::id())
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_photocard' => 'required|exists:ms_photocard,idPhotocard',
            'quantity' => 'required|integer|min:1'
        ]);

        $photocard = MsPhotocard::findOrFail($request->id_photocard);

        // Check stock
        if ($photocard->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Check if item already in cart
        $existingCartItem = TrxKeranjang::where('idUser', Auth::id())
            ->where('idPhotocard', $request->id_photocard)
            ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->jumlah_item + $request->quantity;

            if ($photocard->stok < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah total');
            }

            $existingCartItem->update(['jumlah_item' => $newQuantity]);
        } else {
            TrxKeranjang::create([
                'idUser' => Auth::id(),
                'idPhotocard' => $request->id_photocard,
                'jumlah_item' => $request->quantity,
                'harga_satuan' => $photocard->harga,
                'subtotal' => $photocard->harga * $request->quantity
            ]);
        }

        return back()->with('success', 'Photocard berhasil ditambahkan ke keranjang');
    }

    public function addFromDetail(Request $request)
    {
        $request->validate([
            'id_photocard' => 'required|exists:ms_photocard,idPhotocard',
            'quantity' => 'required|integer|min:1'
        ]);

        $photocard = MsPhotocard::findOrFail($request->id_photocard);

        // Check stock
        if ($photocard->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Check if item already in cart
        $existingCartItem = TrxKeranjang::where('idUser', Auth::id())
            ->where('idPhotocard', $request->id_photocard)
            ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->jumlah_item + $request->quantity;

            if ($photocard->stok < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah total');
            }

            $existingCartItem->update(['jumlah_item' => $newQuantity]);
        } else {
            TrxKeranjang::create([
                'idUser' => Auth::id(),
                'idPhotocard' => $request->id_photocard,
                'jumlah_item' => $request->quantity,
                'harga_satuan' => $photocard->harga,
                'subtotal' => $photocard->harga * $request->quantity
            ]);
        }

        return redirect()->route('cart')->with('success', 'Photocard berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = TrxKeranjang::where('idUser', Auth::id())
            ->where('idKeranjang', $id)
            ->firstOrFail();

        $photocard = $cartItem->photocard;

        if ($photocard->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cartItem->update([
            'jumlah_item' => $request->quantity,
            'subtotal' => $photocard->harga * $request->quantity
        ]);

        return back()->with('success', 'Keranjang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $cartItem = TrxKeranjang::where('idUser', Auth::id())
            ->where('idKeranjang', $id)
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang');
    }
}