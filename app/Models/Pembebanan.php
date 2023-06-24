<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembebanan extends Model
{
    use HasFactory;

    public function stp()
    {
        return $this->hasMany(Stp::class);
    }

    public function stpd()
    {
        return $this->hasMany(Stpd::class);
    }
}
