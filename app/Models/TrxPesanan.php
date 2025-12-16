<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrxPesanan extends Model
{
    use HasFactory;
    
    protected $table = 'trx_pesanan'; 
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(TrxDetailPesanan::class, 'trx_pesanan_id');
    }
}
