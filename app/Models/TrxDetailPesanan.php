<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrxDetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'trx_detail_pesanan';
    protected $guarded = [];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(TrxPesanan::class, 'idPesanan', 'idPesanan');
    }

    public function photocard(): BelongsTo
    {
        return $this->belongsTo(MsPhotocard::class, 'idPhotocard');
    }
}