<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAnggaran extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_manggaran';

    protected $guarded = ['id_manggaran'];
    public $incrementing = false;

    public function paguAnggaran(){
        return $this->hasMany(PaguAnggaran::class, "id_manggaran");
    }
}
