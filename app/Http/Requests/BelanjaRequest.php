<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BelanjaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nominal' => 'required|numeric|gt:0',
            'rka_pengeluaran_id' => 'required',
            'tanggal' => 'required',
        ];
    }
}