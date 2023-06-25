<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHasil extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_master_hasil';
    protected $guarded = ['id_master_hasil'];
}