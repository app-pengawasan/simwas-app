<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterIKU extends Model
{
    use HasFactory, HasUlids;

    protected $table =  'master_iku';
    protected $primaryKey = 'id_iku';

    protected $guarded = ['id_iku'];

    public function sasaran(){
        return $this->belongsTo(MasterSasaran::class, 'id_sasaran');
    }

    public function timKerja(){
        return $this->hasMany(TimKerja::class, 'id_iku');
    }
}
