<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormaHasilTim extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'nh_tims';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function rencanaKerja()
    {
        return $this->belongsTo(RencanaKerja::class, 'tugas_id', 'id_rencanakerja');
    }

    public function normaHasilAccepted()
    {
        return $this->belongsTo(NormaHasilAccepted::class, 'laporan_id', 'id');
    }

    public function normaHasilDokumen()
    {
        return $this->belongsTo(NormaHasilDokumen::class, 'dokumen_id', 'id');
    }
}
