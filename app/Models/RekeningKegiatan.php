<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
