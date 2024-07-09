<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class NormaHasilDokumen extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function laporanPengawasan()
    {
        return $this->belongsTo(LaporanObjekPengawasan::class, 'laporan_pengawasan_id', 'id');
    }
}
