<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RkaPendapatan extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'alokasi' => 'array'
    ];

    public function scopeTa($query, $ta)
    {
        $query->where('ta', $ta);
    }

    public function rekeningPendapatan()
    {
        return $this->belongsTo(RekeningPendapatan::class, 'rekening_id');
    }
}
