<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahKerja extends Model
{
    use HasFactory, HasUlids;
    protected $table = "master_objeks";

    protected $primaryKey = 'id_objek';

    protected $guarded = ['id_objek'];
}
