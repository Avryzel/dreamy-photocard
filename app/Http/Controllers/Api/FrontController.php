<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MsGrupBand;
use App\Models\MsPhotocard;
use App\Models\TrxPesanan;
use App\Models\TrxDetailPesanan;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function getGroups()
    {
        $data = MsGrupBand::all();
        
        return response()->json([
            'message' => 'Success ambil data group',
            'data'    => $data
        ]);
    }

    public function getPhotocards()
    {
        $data = MsPhotocard::with('groupBand')->latest()->get();

        return response()->json([
            'message' => 'Success ambil data photocard',
            'data'    => $data
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'user_id'     => 'required',
            'total_harga' => 'required',
            'items'       => 'required|array',
        ]);

        $trx = TrxPesanan::create([
            'idUser'            => $request->user_id, 
            'total_harga'       => $request->total_harga,
            'status_pesanan'    => 'PERMINTAAN',
            'tanggal_pemesanan' => now(),
            'nomor_resi'        => null,
        ]);

        foreach ($request->items as $item) {
            TrxDetailPesanan::create([
                'idPesanan'  => $trx->idPesanan,
                'ms_photocard_id' => $item['photocard_id'],
                'qty'             => $item['qty'],
                'subtotal'        => $item['subtotal'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'data'    => $trx
        ]);
    }
}