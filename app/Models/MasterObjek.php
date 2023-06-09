<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterObjek extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_objek';
    protected $guarded = ['id_objek'];

    public function kegiatan(){
        return $this->hasMany(ObjekKegiatan::class, "id_objek");
    }
}
