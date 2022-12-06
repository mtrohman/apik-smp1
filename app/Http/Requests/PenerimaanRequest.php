<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenerimaanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nominal' => 'required|numeric|gt:0',
            'rka_pendapatan_id' => 'required',
            'tanggal' => 'required',
        ];
    }
}