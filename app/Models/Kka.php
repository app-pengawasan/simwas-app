<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kka extends Model
{
    use HasFactory;

    public function suratLain()
    {
        return $this->hasMany(Sl::class);
    }
}
