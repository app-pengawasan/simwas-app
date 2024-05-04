<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjekIkuUnitKerja extends Model
{
    use HasFactory;
    public $incrementing = false;
    // allow id to be filled with string
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'satuan',
        'id_target',
        'target_triwulan_1',
        'target_triwulan_2',
        'target_triwulan_3',
        'target_triwulan_4',
        'realisasi_triwulan_1',
        'realisasi_triwulan_2',
        'realisasi_triwulan_3',
        'realisasi_triwulan_4',
        'status',
        'user_id',
        'nilai_y_target',
        'nilai_y_realisasi',
        'id_objek'
    ];

    use HasFactory;

    // add id_objek that references to id_objek in master_objeks table
    public function master_objeks()
    {
        return $this->belongsTo(MasterObjek::class, 'id_objek', 'id_objek');
    }

}
