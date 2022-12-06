<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    protected $guarded = ['id'];

    protected $dates = ['tanggal'];

    public function rkaPendapatan()
    {
        return $this->belongsTo(RkaPendapatan::class);
    }
}
