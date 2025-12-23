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

        $total = $cartItems->sum('subtotal');

        return view('dreamy-store.cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_photocard' => 'required|exists:ms_photocard,idPhotocard',
            'quantity' => 'required|integer|min:1'
        ]);

        $photocard = MsPhotocard::findOrFail($request->id_photocard);
        $userId = Auth::id();

        if ($photocard->stock_pc < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $existingCartItem = TrxKeranjang::where('idUser', $userId)
            ->where('idPhotocard', $request->id_photocard)
            ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->jumlah_item + $request->quantity;

            if ($photocard->stock_pc < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah total');
            }

            $existingCartItem->update([
                'jumlah_item' => $newQuantity,
                'subtotal' => $photocard->harga_pc * $newQuantity
            ]);
        } else {
            TrxKeranjang::create([
                'idUser' => $userId,
                'idPhotocard' => $request->id_photocard,
                'jumlah_item' => $request->quantity,
                'harga_satuan' => $photocard->harga_pc,
                'subtotal' => $photocard->harga_pc * $request->quantity
            ]);
        }

        if ($request->action === 'buy_now') {
            return redirect()->route('cart')->with('success', 'Silahkan lanjut ke pembayaran');
        }

        if ($request->is('product/*')) {
            return redirect()->route('cart')->with('success', 'Berhasil ditambah ke keranjang');
        }

        return back()->with('success', 'Photocard berhasil ditambahkan ke keranjang');
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

        if ($photocard->stock_pc < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cartItem->update([
            'jumlah_item' => $request->quantity,
            'subtotal' => $photocard->harga_pc * $request->quantity
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