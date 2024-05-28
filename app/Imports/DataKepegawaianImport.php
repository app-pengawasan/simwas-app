<?php

namespace App\Imports;

use Closure;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\DataKepegawaian;
use App\Models\MasterDataKepegawaian;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataKepegawaianImport implements ToModel, WithHeadingRow, WithValidation, WithMultipleSheets, WithBatchInserts 
{
    use Importable;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $jenis = MasterDataKepegawaian::where('id', $row['id_jenis_data_kepegawaian'])->value('id');
        $id_pegawai = User::where('nip', $row['nip'])->value('id');
        $data = DataKepegawaian::where('id_pegawai', $id_pegawai)->where('jenis', $jenis)->first();
        if ($data) {
            session()->put('duplikat', 'danger');
            return null;
        }
        return new DataKepegawaian ([
            'id'            => strtolower((string) Str::ulid()),
            'id_pegawai'    => $id_pegawai,
            'jenis'         => $jenis,
            'nilai'         => (double) str_replace(',', '.', $row['nilai']),
        ]);
    }

    public function rules(): array
    {
        return [
            'nip' => 'required|max:18|exists:users,nip',
            'id_jenis_data_kepegawaian' => 'required|exists:master_data_kepegawaians,id',
            'nilai' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    $value = (double) str_replace(',', '.', $value);
                    if ($value < 0 || $value > 100) {
                        $fail("{$attribute} harus bernilai 1-100");
                    }
                },
            ],
        ];
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nip.required' => 'NIP tidak boleh kosong',
            'id_jenis_data_kepegawaian.required' => ':attribute tidak boleh kosong',
            'nilai.required' => 'Nilai tidak boleh kosong',
            'nip.max' => 'Jumlah karakter NIP maksimal :value',
            'nip.exists' => 'NIP pegawai tidak tersedia di database',
            'id_jenis_data_kepegawaian.exists' => 'Jenis data kepegawaian belum terdaftar'
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
