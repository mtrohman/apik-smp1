<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RkaPendapatanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ta' => 'required|min:9|max:9',
            'rekening_id' => 'required',
            'nominal' => 'required',
        ];
    }
}