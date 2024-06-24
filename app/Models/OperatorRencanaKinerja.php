<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class OperatorRencanaKinerja extends Model
{
    use HasFactory, HasUlids;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nama', 'like', '%' . $search . '%');
        });
    }

    public function user()
    {
        // operator_id belongsTo User id
        return $this->belongsTo(User::class, 'operator_id', 'id');
    }
    public function timKerja()
    {
        return $this->hasMany(TimKerja::class);
    }
}
