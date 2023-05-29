<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'          => $row['name'],
            'email'         => $row['email'],
            'password'      => md5($row['password']),
            'nip'           => $row['nip'],
            'pangkat'       => $row['kode_pangkat'],
            'unit_kerja'    => $row['kode_unitkerja'],
            'jabatan'       => $row['kode_jabatan'],
            'is_admin'      => $row['admin'],
            'is_sekma'      => $row['sekretaris_utama'],
            'is_sekwil'     => $row['sekretaris_wilayah'],
            'is_perencana'  => $row['perencana'],
            'is_apkapbn'    => $row['apkapbn'],
            'is_opwil'      => $row['operator_wilayah'],
            'is_analissdm'  => $row['analissdm'],
        ]);
    }
}
