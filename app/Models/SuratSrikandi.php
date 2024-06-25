<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratSrikandi extends Model
{
    use HasFactory;
    use HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('usulan_nomor', 'like', '%' . $search . '%');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // one to one belongsTo usulanSuratSrikandi id_usulan_surat_srikandi
    public function usulanSuratSrikandi()
    {
        return $this->belongsTo(UsulanSuratSrikandi::class, 'id_usulan_surat_srikandi');

    }

    public function kodeKlasifikasiArsip()
    {
        return $this->belongsTo(KodeKlasifikasiArsip::class, 'kode_klasifikasi_arsip_srikandi', 'id');
    }
}
