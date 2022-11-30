<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningKegiatanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rekening_id' => 'required',
            'kode_kegiatan' => 'required',
            'nama_kegiatan' => 'required',
        ];
    }
}