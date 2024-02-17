<?php

namespace App\Models;

use App\Models\User;
use App\Models\MasterIKU;
use App\Models\RencanaKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimKerja extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_timkerja';
    protected $guarded = ['id_timkerja'];

    public function ketua(){
        return $this->belongsTo(User::class, 'id_ketua', 'id');
    }

    public function operator(){
        return $this->belongsTo(User::class, 'id_operator', 'id');
    }

    public function iku(){
        return $this->belongsTo(MasterIKU::class, 'id_iku');
    }

    public function rencanaKerja(){
        return $this->hasMany(RencanaKerja::class, 'id_timkerja');
    }
}
