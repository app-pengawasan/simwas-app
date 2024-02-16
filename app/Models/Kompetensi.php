<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kompetensi extends Model
{
    use HasFactory, HasUlids;
    
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public $incrementing = false;

    public function pp()
    {
        return $this->belongsTo(Pp::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, "pegawai_id", "id");
    }

    public function analis()
    {
        return $this->belongsTo(User::class, "approved_by", "id");
    }

    public function namaPp()
    {
        return $this->belongsTo(NamaPp::class);
    }
}
