<?php

namespace App\Imports;

use Exception;
use App\Models\MasterObjek;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WilayahKerjaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try{
            $data = MasterObjek::where('kode_wilayah', $row['kode_wilayah'])->where('kategori', 3)->first();
            if($data){
                return null;
            }
            return new MasterObjek([
                'kode_wilayah'      => $row['kode_wilayah'],
                'nama'              => $row['nama'],
                'kategori'          => 3
            ]);
        }catch(Exception $e){

        }
    }
}
