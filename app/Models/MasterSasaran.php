<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSasaran extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_sasaran';

    protected $guarded = ['id_sasaran'];

    public function tujuan(){
        return $this->belongsTo(MasterTujuan::class, "id_tujuan");
    }

    public function iku(){
        return $this->hasMany(MasterIKU::class, 'id_sasaran');
    }
}
