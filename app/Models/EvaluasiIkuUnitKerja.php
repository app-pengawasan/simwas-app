<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class EvaluasiIkuUnitKerja extends Model
{
    use HasFactory, HasUlids;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    // user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pic', 'id');
    }

}
