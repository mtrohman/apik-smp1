<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RkaPengeluaran extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'sumber_dana' => 'array',
        'alokasi' => 'array'
    ];

    public function scopeTa($query, $ta)
    {
        $query->where('ta', $ta);
    }

    public function scopeParent($query, $id)
    {
        return $query->whereHas('rekeningKegiatan', function ($qrk) use ($id) {
            $qrk->whereHas('rekeningPengeluaran', function ($qrp) use ($id) {
                $qrp->whereHas('parentPengeluaran', function ($q) use ($id) {
                    $q->where('id', $id);   
                });
            });
        });
    }

    public function rekeningKegiatan()
    {
        return $this->belongsTo(RekeningKegiatan::class, 'kegiatan_id');
    }
}
