<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory; use HasUlids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function laporanOPengawasan(): BelongsTo
    {
        return $this->belongsTo(LaporanObjekPengawasan::class, "laporan_opengawasan","id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "id_pegawai","id");
    }
}
