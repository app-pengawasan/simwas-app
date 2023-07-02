<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StKinerja extends Model
{
    use HasFactory, HasUlids;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('objek', 'like', '%' . $search . '%');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dalnis()
    {
        return $this->belongsTo(User::class, 'dalnis_id');
    }

    public function ketuaKoor()
    {
        return $this->belongsTo(User::class, 'ketua_koor_id');
    }

    public function stpd()
    {
        return $this->hasMany(Stpd::class);
    }

    public function normaHasil()
    {
        return $this->hasMany(NormaHasil::class);
    }

    public function pimpinan()
    {
        return $this->belongsTo(MasterPimpinan::class, 'penandatangan', 'id_pimpinan');
    }

    public function rencanaKerja()
    {
        return $this->belongsTo(RencanaKerja::class, 'rencana_id', 'id_rencanakerja');
    }
}
