<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaguAnggaran extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_panggaran';

    public $guarded = ["id_panggaran"];

    public function masterAnggaran(){
        return $this->belongsTo(MasterAnggaran::class, "id_manggaran");
    }
}
