<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjekPengawasan extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_opengawasan';
    protected $guarded = ['id_opengawasan'];

    public function laporanObjekPengawasan()
    {
        return $this->hasMany(LaporanObjekPengawasan::class, 'id_objek_pengawasan', 'id_opengawasan');
    }

    public function masterObjek()
    {
        return $this->belongsTo(MasterObjek::class, 'id_objek', 'id_objek');
    }
}
