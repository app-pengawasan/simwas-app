<?php

namespace App\Imports;

use App\Models\MasterObjek;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitKerjaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try{
            $data = MasterObjek::where('kode_unitkerja', $row['kode_unitkerja'])->where('kategori', 1)->first();
            if($data){
                return null;
            }
            return new MasterObjek([
                'kode_wilayah'      => $row['kode_wilayah'],
                'kode_unitkerja'    => $row['kode_unitkerja'],
                'nama'              => $row['nama'],
                'kategori'          => 1
            ]);
        }catch(Exception $e){

        }
    }
}
