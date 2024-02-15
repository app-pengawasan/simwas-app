<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsulanSuratSrikandiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pejabatPenandaTangan' => 'required',
            'jenisNaskahDinas' => 'required',
            'jenisNaskahDinasPenugasan' => 'required',
            'kegiatan' => 'required',
            'derajatKeamanan' => 'required',
            'kodeKlasifikasiArsip' => 'required',
            'melaksanakan' => 'required',
            'usulanTanggal' => 'required',
            'file' => 'required|mimes:doc,docx,pdf|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'pejabatPenandaTangan.required' => 'Pejabat Penanda Tangan harus diisi',
            'jenisNaskahDinas.required' => 'Jenis Naskah Dinas harus diisi',
            'jenisNaskahDinasPenugasan.required' => 'Jenis Naskah Dinas Penugasan harus diisi',
            'kegiatan.required' => 'Kegiatan harus diisi',
            'derajatKeamanan.required' => 'Derajat Keamanan harus diisi',
            'kodeKlasifikasiArsip.required' => 'Kode Klasifikasi Arsip harus diisi',
            'melaksanakan.required' => 'Melaksanakan harus diisi',
            'usulanTanggal.required' => 'Usulan Tanggal harus diisi',
            'file.required' => 'File harus diisi',
            'file.mimes' => 'File harus berupa file .doc, .docx, atau .pdf',
            'file.max' => 'File maksimal 2MB',
            'file2.required' => 'File harus diunggah',
        ];
    }
}
