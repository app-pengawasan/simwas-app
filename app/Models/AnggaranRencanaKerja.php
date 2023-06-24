<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggaranRencanaKerja extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_rkanggaran';
    protected $guarded = ['id_rkanggaran'];
}