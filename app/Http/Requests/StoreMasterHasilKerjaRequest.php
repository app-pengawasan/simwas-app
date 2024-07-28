<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterHasilKerjaRequest extends FormRequest
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
            'masterUnsurId' => 'required',
            'masterSubUnsurId' => 'required',
            'namaHasilKerja' => 'required',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'masterUnsurId.required' => 'Unsur tidak boleh kosong',
            'masterSubUnsurId.required' => 'Sub Unsur tidak boleh kosong',
            'namaHasilKerja.required' => 'Nama Hasil Kerja tidak boleh kosong',
            'status.required' => 'Status tidak boleh kosong',
        ];
    }
}
