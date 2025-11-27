<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsGrupBand extends Model
{ 
    use HasFactory;
    
    protected $table = 'ms_grup_band'; 
    protected $primaryKey = 'idGroupBand'; 
    public $incrementing = true; 

    protected $fillable = ['nama_group'];
}