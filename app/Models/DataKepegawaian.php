<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class DataKepegawaian extends Model
{
    use HasFactory;
    
    protected $fillable = ['id', 'id_pegawai', 'jenis', 'nilai'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pegawai', 'id');
    }

    public function masterdk()
    {
        return $this->belongsTo(MasterDataKepegawaian::class, 'jenis', 'id');
    }
}
