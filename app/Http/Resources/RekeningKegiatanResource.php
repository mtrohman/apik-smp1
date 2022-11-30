<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RekeningKegiatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'rekening_id' => $this->rekening_id,
            'kode_kegiatan' => $this->kode_kegiatan,
            'nama_kegiatan' => $this->nama_kegiatan,
        ];
    }
}
