<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Proyek extends Model
{
    use HasFactory;
    use HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function timKerja()
    {
        return $this->belongsTo(TimKerja::class, 'id_tim_kerja');
    }

    public function rencanaKerja()
    {
        return $this->hasMany(RencanaKerja::class, 'id_proyek');
    }
}
