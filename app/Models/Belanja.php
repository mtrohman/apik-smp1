<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belanja extends Model
{
    protected $guarded = ['id'];

    protected $dates = ['tanggal'];

    public function rkaPengeluaran()
    {
        return $this->belongsTo(RkaPengeluaran::class);
    }
}
