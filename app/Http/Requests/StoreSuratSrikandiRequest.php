<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratSrikandiRequest extends FormRequest
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
            'jenisNaskahDinas' => ['required', 'string', 'max:255'],
            'tanggal_persetujuan_srikandi' => ['required', 'date'],
            'nomor_surat_srikandi' => ['required', 'string', 'max:255'],
            'derajatKeamanan' => ['required', 'string', 'max:255'],
            'kodeKlasifikasiArsip' => ['required', 'string', 'max:255'],
            'pejabatPenandaTangan' => ['required', 'string', 'max:255'],
            'link_srikandi' => ['required', 'string', 'max:255'],
            'upload_word_document' => ['required', 'file', 'mimes:doc,docx'],
            'upload_pdf_document' => ['required', 'file', 'mimes:pdf'],
        ];
    }
}
