<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsulanSuratSrikandi extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;
    // user_id has many

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
    // has many suratSrikandi
    public function suratSrikandi()
    {
        return $this->hasMany(SuratSrikandi::class, 'id_usulan_surat_srikandi', 'id');
        // add foreign key
    }
    public function kodeKlasifikasiArsip()
    {
        return $this->belongsTo(KodeKlasifikasiArsip::class, 'kode_klasifikasi_arsip', 'id');
    }
    public function rencanaKerja(): BelongsTo
    {
        return $this->belongsTo(RencanaKerja::class, "rencana_kerja_id","id_rencanakerja");
    }

}
