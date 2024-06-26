<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormaHasil extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function stKinerja()
    {
        return $this->belongsTo(StKinerja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // belongs to rencana kerjas
    public function rencanaKerja()
    {
        return $this->belongsTo(RencanaKerja::class, 'tugas_id', 'id_rencanakerja');
    }

    // one on one to NormaHasilAccepted
    public function normaHasilAccepted()
    {
        return $this->hasOne(NormaHasilAccepted::class, 'id_norma_hasil', 'id');
    }

    public function objekNormaHasil()
    {
        return $this->hasMany(ObjekNormaHasil::class, 'norma_hasil_id', 'id');
    }
    public function laporanPengawasan()
    {
        return $this->belongsTo(LaporanObjekPengawasan::class, 'laporan_pengawasan_id', 'id');
    }

    public function masterLaporan()
    {
        return $this->belongsTo(MasterLaporan::class, 'jenis_norma_hasil_id', 'id');
    }

}
