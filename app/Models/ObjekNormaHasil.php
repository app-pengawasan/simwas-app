<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjekNormaHasil extends Model
{
    use HasFactory;

    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('objek_norma_hasil', 'like', '%' . $search . '%');
        });
    }

    public function masterObjek()
    {
        return $this->belongsTo(MasterObjek::class, 'objek_id', 'id_objek');
    }

    public function normaHasil()
    {
        return $this->belongsTo(NormaHasil::class, 'norma_hasil_id', 'id');
    }
}
