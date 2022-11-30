<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningPengeluaranRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_id' => 'required',
            'kode_rekening' => 'required',
            'nama_rekening' => 'required',
        ];
    }
}