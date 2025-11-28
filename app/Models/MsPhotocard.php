<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsPhotocard extends Model
{
    protected $table = 'ms_photocard';

    protected $primaryKey = 'idPhotocard';

    protected $fillable = [
        'idGroupBand',
        'nama_pc',
        'deskripsi_pc',
        'stock_pc',
        'harga_pc',
        'foto_pc',
    ];

    public function groupBand()
    {
        return $this->belongsTo(MsGrupBand::class, 'idGroupBand', 'idGroupBand');
    }
}
