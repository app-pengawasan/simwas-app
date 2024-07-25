<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class NormaHasilAccepted extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

    // one on one to NormaHasil
    public function normaHasil()
    {
        return $this->belongsTo(NormaHasil::class, 'id_norma_hasil', 'id');
    }

    public function normaHasilTim(){
        return $this->hasOne(NormaHasilTim::class, 'laporan_id', 'id');
    }
}
