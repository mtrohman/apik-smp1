<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class RekeningPengeluaran extends Model
{
    protected $guarded = ['id'];

    public function parentPengeluaran()
    {
        return $this->belongsTo(RekeningParentPengeluaran::class, 'parent_id');
    }

    public function rekeningKegiatan()
    {
        return $this->hasMany(RekeningKegiatan::class, 'rekening_id')->where('ta', Cookie::get('ta'));
    }

    public function scopeParent($query, $id)
    {
        return $query->whereHas('parentPengeluaran', function ($q) use ($id) {
            $q->where('id', $id);   
        });
    }
}
