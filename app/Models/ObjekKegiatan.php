<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjekKegiatan extends Model
{
    use HasFactory, HasUlids;
    protected $table = "objek_kegiatans";

    protected $primaryKey = 'id_okegiatan';

    protected $guarded = ['id_okegiatan'];

    // public function unitKerja(){
    //     return $this->belongsTo(MasterObjek::class, "id_objek");
    // }
}