<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaliMutuTim extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'km_tims';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function rencanaKerja()
    {
        return $this->belongsTo(RencanaKerja::class, 'tugas_id', 'id_rencanakerja');
    }
}
