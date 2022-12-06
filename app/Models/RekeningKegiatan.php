<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class RekeningKegiatan extends Model
{
    protected $guarded = ['id'];

    public function scopeTa($query, $ta)
    {
        $query->where('ta', $ta);
    }

    public function rekeningPengeluaran()
    {
        return $this->belongsTo(RekeningPengeluaran::class, 'rekening_id');
    }

    public function rkaPengeluaran()
    {
        return $this->hasOne(RkaPengeluaran::class, 'kegiatan_id')->where('ta', Cookie::get('ta'));
    }
}
