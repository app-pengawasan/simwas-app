<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterLaporan extends Model
{

    use HasFactory, HasUlids;


    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('kode_laporan', 'like', '%' . $search . '%')
                ->orWhere('nama_laporan', 'like', '%' . $search . '%');
        });
    }

}
