<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class MasterHasilKerja extends Model

{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nama_hasil_kerja', 'like', '%' . $search . '%');
        });
    }

    public function masterSubUnsur()
    {
        return $this->belongsTo(MasterSubUnsur::class, 'master_subunsur_id', 'id');
    }
}
