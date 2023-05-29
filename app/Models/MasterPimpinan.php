<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPimpinan extends Model
{
    use HasFactory, HasUlids;

    /**
     * The primary key associated with the table
     * @var string
     */
    protected $primaryKey = 'id_pimpinan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = ['name', 'email', 'password',];
    protected $guarded = ['id_pimpinan'];

    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class, "id_user");
    }
}
