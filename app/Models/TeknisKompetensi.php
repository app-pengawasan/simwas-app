<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknisKompetensi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jenis()
    {
        return $this->belongsTo(JenisKompetensi::class, 'jenis_id', 'id');
    }
}
