<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrxPesanan extends Model
{
    use HasFactory;
    
    protected $table = 'trx_pesanan'; 
    protected $guarded = [];
    protected $primaryKey = 'idPesanan';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function details(): HasMany
    {
        return $this->hasMany(TrxDetailPesanan::class, 'idPesanan', 'idPesanan');
    }
}
