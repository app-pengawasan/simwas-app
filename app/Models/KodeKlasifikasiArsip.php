<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class KodeKlasifikasiArsip extends Model
{

    use HasFactory, HasUlids;


    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('kode', 'like', '%' . $search . '%')
                ->orWhere('uraian', 'like', '%' . $search . '%');
        });
    }

    public function usulanSuratSrikandi()
    {
        return $this->hasMany(UsulanSuratSrikandi::class, 'kode_klasifikasi_arsip', 'id');
    }

    public function suratSrikandi()
    {
        return $this->hasMany(SuratSrikandi::class, 'kode_klasifikasi_arsip_srikandi', 'id');
    }


}
