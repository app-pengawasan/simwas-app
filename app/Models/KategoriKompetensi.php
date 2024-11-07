<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKompetensi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function stp()
    {
        return $this->hasMany(Stp::class);
    }

    public function jenis()
    {
        return $this->hasMany(JenisKompetensi::class, 'kategori_id', 'id');
    }
}
