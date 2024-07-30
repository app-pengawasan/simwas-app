<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterKinerjaRequest extends FormRequest
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
        if ($this->input('status') == 'ngt') {
            return [
                "hasilKerjaID" => "required",
                "status" => "required",
                "hasilKerja_penanggungJawabKegiatan" => "required",
                "rencanaKinerja_penanggungJawabKegiatan" => "required",
                "iki_penanggungJawabKegiatan" => "required",
                "kegiatan_penanggungJawabKegiatan" => "required",
                "capaian_penanggungJawabKegiatan" => "required",
                "hasilKerja_PIC" => "required",
                "rencanaKinerja_PIC" => "required",
                "iki_PIC" => "required",
                "kegiatan_PIC" => "required",
                "capaian_PIC" => "required",
                "hasilKerja_anggotaTim" => "required",
                "rencanaKinerja_anggotaTim" => "required",
                "iki_anggotaTim" => "required",
                "kegiatan_anggotaTim" => "required",
                "capaian_anggotaTim" => "required",
            ];
        } else {
            return [
                "hasilKerjaID" => "required",
                "status" => "required",
                "hasilKerja_pengendaliTeknis" => "required",
                "rencanaKinerja_pengendaliTeknis" => "required",
                "iki_pengendaliTeknis" => "required",
                "kegiatan_pengendaliTeknis" => "required",
                "capaian_pengendaliTeknis" => "required",
                "hasilKerja_ketuaTim" => "required",
                "rencanaKinerja_ketuaTim" => "required",
                "iki_ketuaTim" => "required",
                "kegiatan_ketuaTim" => "required",
                "capaian_ketuaTim" => "required",
                "hasilKerja_anggotaTim" => "required",
                "rencanaKinerja_anggotaTim" => "required",
                "iki_anggotaTim" => "required",
                "kegiatan_anggotaTim" => "required",
                "capaian_anggotaTim" => "required",
            ];
        }
    }
    public function messages()
    {
        return [
            'hasilKerjaID.required' => 'Pilih hasil kinerja',
            'status.required' => 'Pilih status',
            'hasilKerja_pengendaliTeknis.required' => 'Isi hasil kerja pengendali teknis',
            'rencanaKinerja_pengendaliTeknis.required' => 'Isi rencana kinerja pengendali teknis',
            'iki_pengendaliTeknis.required' => 'Isi IKI pengendali teknis',
            'kegiatan_pengendaliTeknis.required' => 'Isi kegiatan pengendali teknis',
            'capaian_pengendaliTeknis.required' => 'Isi capaian pengendali teknis',
            'hasilKerja_ketuaTim.required' => 'Isi hasil kerja ketua tim',
            'rencanaKinerja_ketuaTim.required' => 'Isi rencana kinerja ketua tim',
            'iki_ketuaTim.required' => 'Isi IKI ketua tim',
            'kegiatan_ketuaTim.required' => 'Isi kegiatan ketua tim',
            'capaian_ketuaTim.required' => 'Isi capaian ketua tim',
            'hasilKerja_anggotaTim.required' => 'Isi hasil kerja anggota tim',
            'rencanaKinerja_anggotaTim.required' => 'Isi rencana kinerja anggota tim',
            'iki_anggotaTim.required' => 'Isi IKI anggota tim',
            'kegiatan_anggotaTim.required' => 'Isi kegiatan anggota tim',
            'capaian_anggotaTim.required' => 'Isi capaian anggota tim',

        ];
    }
}
