<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stpd extends Model
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

    public function stKinerja()
    {
        return $this->belongsTo(StKinerja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembebanan()
    {
        return $this->belongsTo(Pembebanan::class);
    }

    public function pimpinan()
    {
        return $this->belongsTo(MasterPimpinan::class, 'penandatangan', 'id_pimpinan');
    }
}
