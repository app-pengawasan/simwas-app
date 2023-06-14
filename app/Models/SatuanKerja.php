<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanKerja extends Model
{
    use HasFactory, HasUlids;

    protected $table = "master_objeks";

    protected $guarded = ['id_objek'];
}
