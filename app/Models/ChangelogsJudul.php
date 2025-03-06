<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChangelogsJudul extends Model
{
    use HasFactory;

    protected $table = "judul_changelog";
    protected $primaryKey = 'id_judulchangelog';
    // protected $guarded = ['id_judulchangelog'];
    protected $fillable = ['id_judulchangelog', 'versi', 'tgl_changelog', 'judul', 'keterangan'];

    public function changelogsisi() {
        return $this->hasMany(ChangelogsIsi::class, 'id_judulchangelog');
    }
}
