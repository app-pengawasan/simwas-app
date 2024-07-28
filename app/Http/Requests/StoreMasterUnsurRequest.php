<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterUnsurRequest extends FormRequest
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
            'namaUnsur' => ['required', 'string', 'max:100'],
        ];
    }
    public function messages()
    {
        return [
            'namaUnsur.required' => 'Nama unsur harus diisi',
        ];
    }
}
