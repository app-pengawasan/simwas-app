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
            'objek_kegiatan' => ['required', 'string', 'max:100'],
            'bulan_pelaporan' => ['required', 'string', 'max:100'],
            'jenis_norma_hasil' => ['required', 'string', 'max:100'],
            'nama_dokumen' => ['required', 'string', 'max:500'],
            'url_norma_hasil' => ['required', 'url', 'max:100'],
        ];
    }
    public function messages()
    {
        return [
            'rencana_id.required' => 'Harus memilih tugas',
            'objek_kegiatan.required' => 'Objek kegiatan harus diisi',
            'bulan_pelaporan.required' => 'Bulan pelaporan harus diisi',
            'jenis_norma_hasil.required' => 'Jenis norma hasil harus diisi',
            'nama_dokumen.required' => 'Nama dokumen harus diisi',
            'url_norma_hasil.required' => 'URL dokumen harus diisi',
        ];
    }
}
