<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pp extends Model
{
    use HasFactory;

    public function stp()
    {
        return $this->hasMany(Stp::class);
    }

    public function namaPp()
    {
        return $this->hasMany(NamaPp::class);
    }
}
