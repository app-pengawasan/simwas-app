<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaPp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pp()
    {
        return $this->belongsTo(Pp::class);
    }
}
