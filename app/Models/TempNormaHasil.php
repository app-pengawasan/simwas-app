<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempNormaHasil extends Model
{
    use HasFactory;

    protected $table = 'temp_norma_hasils';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = false;

}
