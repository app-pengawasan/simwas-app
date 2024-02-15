<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class MasterSubUnsur extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nama_sub_unsur', 'like', '%' . $search . '%');
        });
    }

    public function masterUnsur()
    {
        return $this->belongsTo(MasterUnsur::class);
    }

    public function masterHasilKerjas()
    {
        return $this->hasMany(MasterHasilKerja::class);
    }
}
