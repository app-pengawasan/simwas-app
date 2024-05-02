<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNormaHasilRequest extends FormRequest
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
            'rencana_id' => ['required', 'string', 'max:100'],
            'jenis_norma_hasil' => ['required', 'string', 'max:100'],
            'nama_dokumen' => ['required', 'string', 'max:100'],
            // file upload word extension
            'file' => ['required', 'file', 'mimes:doc,docx,pdf', 'max:2048'],

        ];
    }
}
