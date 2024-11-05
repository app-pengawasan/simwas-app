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

    public function teknis()
    {
        return $this->belongsTo(TeknisKompetensi::class, 'teknis_id', 'id');
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, "pegawai_id", "id");
    }

    public function analis()
    {
        return $this->belongsTo(User::class, "approved_by", "id");
    }

    public function penyelenggaraDiklat()
    {
        return $this->belongsTo(MasterPenyelenggara::class, "penyelenggara", "id");
    }
}
