<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelaksanaTugas extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id_pelaksana';
    protected $guarded    = ['id_pelaksana'];

    public function user()
    {
        return $this->belongsTo(User::class, "id_pegawai", "id");
    }

    public function rencanaKerja(): BelongsTo
    {
        return $this->belongsTo(RencanaKerja::class, "id_rencanakerja","id_rencanakerja");
    }

    public function hasil()
    {
        return $this->belongsTo(MasterHasil::class, "pt_hasil", "kategori_hasilkerja");
    }
}
