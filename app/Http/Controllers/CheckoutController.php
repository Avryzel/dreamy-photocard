<?php

namespace App\Http\Controllers;

use App\Models\TrxPesanan;
use App\Models\TrxDetailPesanan;
use App\Models\TrxKeranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $user = Auth::user();

        $cartItems = TrxKeranjang::with('photocard')
                                ->where('idUser', $user->idUser)
                                ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            $totalHarga = $cartItems->sum('subtotal');

            // 1. Simpan Header Pesanan (Sesuai perbaikan sebelumnya)
            $order = TrxPesanan::create([
                'idUser'         => $user->idUser,
                'total_harga'    => $totalHarga,
                'status_pesanan' => 'PERMINTAAN',
            ]);

            $newOrderId = $order->idPesanan; 

            $waMessage = "Halo Admin Dreamy 👋\n\nSaya ingin memesan (Order ID: #{$newOrderId}):\n\n";

            foreach ($cartItems as $index => $item) {
                TrxDetailPesanan::create([
                    'idPesanan'      => $newOrderId,
                    'idPhotocard'    => $item->idPhotocard,
                    'jumlah'         => $item->jumlah_item,
                    'harga_per_item' => $item->harga_satuan,
                ]);

                $namaBarang = $item->photocard ? $item->photocard->nama_pc : 'Photocard';

                $waMessage .= ($index + 1) . ". " . $namaBarang . "\n";
                $waMessage .= "   Qty: " . $item->jumlah_item . "\n";
            }

            $waMessage .= "\nTotal: Rp " . number_format($totalHarga, 0, ',', '.') . "\n";
            $waMessage .= "Nama: " . $user->name . "\n";
            $waMessage .= "Email: " . $user->email . "\n";
            $waMessage .= "Mohon diproses ya! 🙏";

            TrxKeranjang::where('idUser', $user->idUser)->delete();

            DB::commit();

            $adminPhone = "6282114931198";
            $waUrl = "https://wa.me/" . $adminPhone . "?text=" . urlencode($waMessage);

            return redirect()->away($waUrl);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}