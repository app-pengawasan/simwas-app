<?php

namespace App\Imports;

use Exception;
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
        try{
            $data = MasterObjek::where('kode_satuankerja', $row['kode_satuankerja'])->where('kategori', 2)->first();
            if($data){
                return null;
            }
            return new MasterObjek([
                'kode_wilayah'      => $row['kode_wilayah'],
                'kode_satuankerja'  => $row['kode_satuankerja'],
                'nama'              => $row['nama'],
                'kategori'          => 2
            ]);
        }catch(Exception $e){

        }
    }
}
