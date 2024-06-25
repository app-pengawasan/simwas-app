<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKodeKlasifikasiArsipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'kode-kka' => 'required',
            'uraian-kka' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'kode-kka.required' => 'Kode Klasifikasi Arsip harus diisi',
            'uraian-kka.required' => 'Uraian Klasifikasi Arsip harus diisi',
        ];
    }
}
