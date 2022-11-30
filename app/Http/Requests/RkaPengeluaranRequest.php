<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RkaPengeluaranRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ta' => 'required|min:4|max:4',
            'rekening_id' => 'required',
            'kegiatan_id' => 'required',
            'nominal' => 'required',
            'triwulan_1' => 'required',
            'triwulan_2' => 'required',
            'triwulan_3' => 'required',
            'triwulan_4' => 'required',
            'apbd' => 'required',
            'bos' => 'required',
            'spm' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->get('triwulan_1') + $this->get('triwulan_2') + $this->get('triwulan_3') + $this->get('triwulan_4')  != ( $this->get('apbd') + $this->get('bos') + $this->get('spm') ) ) {
                $validator->errors()->add('triwulan_1', 'Periksa kembali nilai ini');
                $validator->errors()->add('triwulan_2', 'Periksa kembali nilai ini');
                $validator->errors()->add('triwulan_3', 'Periksa kembali nilai ini');
                $validator->errors()->add('triwulan_4', 'Periksa kembali nilai ini');
                $validator->errors()->add('apbd', 'Periksa kembali nilai ini');
                $validator->errors()->add('bos', 'Periksa kembali nilai ini');
                $validator->errors()->add('spm', 'Periksa kembali nilai ini');
                $validator->errors()->add('nominal', 'Total Alokasi Triwulan Tidak sama dengan Total Sumber Dana');
            }
        });
    }
}