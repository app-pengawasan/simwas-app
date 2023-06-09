<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterUnitKerja extends Model
{
    use HasFactory;

    protected $table = "master_objeks";

    protected $guarded = ['id_objek'];
}
