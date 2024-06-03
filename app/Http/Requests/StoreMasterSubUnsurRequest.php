<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterSubUnsurRequest extends FormRequest
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
            'namaSubUnsur' => 'required',
            'masterUnsurId' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'namaSubUnsur.required' => 'Nama Sub Unsur tidak boleh kosong',
            'masterUnsurId.required' => 'Unsur tidak boleh kosong',
        ];
    }
}
