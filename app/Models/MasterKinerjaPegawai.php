<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterKinerjaPegawai extends Model
{
   use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nama_kinerja', 'like', '%' . $search . '%');
        });
    }

    public function masterHasilKerja()
    {
        return $this->belongsTo(MasterHasilKerja::class, 'kinerja_id', 'id');
    }


}
