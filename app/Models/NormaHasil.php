<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormaHasil extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function stKinerja()
    {
        return $this->belongsTo(Stk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
