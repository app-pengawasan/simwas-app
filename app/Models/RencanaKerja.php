<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaKerja extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_rencanakerja';
    protected $guarded = ['id_rencanakerja'];

    public function hasilKerja(){
        return $this->belongsTo(MasterHasilKerja::class, 'id_hasilkerja', 'id');
    }

    public function timkerja(){
        return $this->belongsTo(TimKerja::class,'id_timkerja', 'id_timkerja');
    }

    public function objekPengawasan(){
        return $this->hasMany(ObjekPengawasan::class,'id_rencanakerja');
    }

    public function anggaran(){
        return $this->hasMany(AnggaranRencanaKerja::class, 'id_rencanakerja');
    }

    public function pelaksana(){
        return $this->hasMany(PelaksanaTugas::class, 'id_rencanakerja');
    }

    public function proyek(){
        return $this->belongsTo(Proyek::class, 'id_proyek');
    }

    // has many norma hasil
    public function normaHasil()
    {
        return $this->hasMany(NormaHasil::class, 'id_rencanakerja');
    }
}
