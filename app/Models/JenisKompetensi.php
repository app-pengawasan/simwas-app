<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKompetensi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(KategoriKompetensi::class, 'kategori_id', 'id');
    }

    public function teknis() 
    {
        return $this->hasMany(TeknisKompetensi::class);
    }
}
