<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxKeranjang extends Model
{
    use HasFactory;

    protected $table = 'trx_keranjang';
    protected $primaryKey = 'idKeranjang';
    public $timestamps = true;

    protected $fillable = [
        'idUser',
        'idPhotocard',
        'jumlah_item',
        'harga_satuan',
        'subtotal'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'jumlah_item' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function photocard()
    {
        return $this->belongsTo(MsPhotocard::class, 'idPhotocard', 'idPhotocard');
    }
}