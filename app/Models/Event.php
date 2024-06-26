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

    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(PelaksanaTugas::class, "id_pelaksana","id_pelaksana");
    }
}
