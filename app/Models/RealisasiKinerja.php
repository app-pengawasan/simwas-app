<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RealisasiKinerja extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $guarded    = ['id'];

    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(PelaksanaTugas::class, "id_pelaksana","id_pelaksana");
    }

    public function getPenilai(): BelongsTo
    {
        return $this->belongsTo(User::class, "penilai", "id");
    }
}
