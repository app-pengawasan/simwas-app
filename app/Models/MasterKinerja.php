<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterKinerja extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('hasil_kerja_id', 'like', '%' . $search . '%');
        });
    }

    public function masterHasilKerja()
    {
        return $this->belongsTo(MasterHasilKerja::class, 'hasil_kerja_id', 'id');
    }

    public function masterKinerjaPegawai()
    {
        return $this->hasMany(MasterKinerjaPegawai::class, 'kinerja_id', 'id');
    }




}
