<?php

namespace App\Imports;

use App\Models\MasterObjek;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SatuanKerjaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MasterObjek([
            'kode_wilayah'      => $row['kode_wilayah'],
            'kode_satuankerja'  => $row['kode_satuankerja'],
            'nama'              => $row['nama'],
            'kategori'          => 2
        ]);
    }
}
