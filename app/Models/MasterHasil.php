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

    // master_subunsur_id belongs to id in master_sub_unsurs
    public function masterSubUnsur()
    {
        return $this->belongsTo(MasterSubUnsur::class, 'master_subunsur_id');
    }
}
