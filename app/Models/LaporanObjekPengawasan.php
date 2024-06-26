<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanObjekPengawasan extends Model
{
        use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function objekPengawasan()
    {
        return $this->belongsTo(ObjekPengawasan::class, 'id_objek_pengawasan', 'id_opengawasan');
    }
    public function normaHasil()
    {
        return $this->hasMany(NormaHasil::class, 'laporan_pengawasan_id', 'id');
    }
}
