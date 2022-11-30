<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningPendapatan extends Model
{
    protected $guarded = ['id'];

    public function parentPendapatan()
    {
        return $this->belongsTo(RekeningParentPendapatan::class, 'parent_id');
    }
}
