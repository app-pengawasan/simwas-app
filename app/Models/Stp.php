<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stp extends Model
{
    use HasFactory, HasUlids;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    protected $with = ['pp'];
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['user'] ?? false, function($query, $user){
            return $query->whereHas('user', function($query) use ($user) {
                $query->where('id', $user);
            });
        });
        
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('nama_pp', 'like', '%' . $search . '%');
        });

        $query->when($filters['pp'] ?? false, function($query, $pp){
            return $query->whereHas('pp', function($query) use ($pp) {
                $query->where('id', $pp);
            });
        });
    }

    public function pp()
    {
        return $this->belongsTo(Pp::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
