<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTujuan extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_tujuan';

    protected $guarded = ['id_tujuan'];

    public function Sasaran(){
        return $this->hasMany(MasterSasaran::class, "id_tujuan");
    }
}
