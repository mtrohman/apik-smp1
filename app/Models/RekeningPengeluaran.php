<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningPengeluaran extends Model
{
    protected $guarded = ['id'];

    public function parentPengeluaran()
    {
        return $this->belongsTo(RekeningParentPengeluaran::class, 'parent_id');
    }
}
