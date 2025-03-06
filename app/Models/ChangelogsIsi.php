<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangelogsIsi extends Model
{
    use HasFactory;

    protected $table = "isi_changelog";
    protected $primaryKey = 'id_isichangelog';
    // protected $guarded = ['id_isichangelog'];
    protected $fillable = ['id_judulchangelog', 'isi'];

    public function changelogsjudul(){
        return $this->belongsTo(ChangelogsJudul::class, 'id_judulchangelog');
    }
}
