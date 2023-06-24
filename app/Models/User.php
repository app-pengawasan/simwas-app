<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

    /**
     * The primary key associated with the table
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = ['name', 'email', 'password',];
    protected $guarded = ['id'];

    /**
     * Indicates if the model's ID isn't auto-incrementing
     * @var bool
     */
    public $incrementing = false;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'nip' => '9999999999999999999',
        'name' => 'anonimous',
        'pangkat' => 'IV/a',
        'unit_kerja' => '8010',
        'jabatan' => '90',
        'is_aktif' => false,
        'is_admin' => false,
        'is_sekma' => false,
        'is_sekwil' => false,
        'is_perencana' => false,
        'is_apkapbn' => false,
        'is_opwil' => false,
        'is_analissdm' => false
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function masterPimpinan(){
        return $this->hasMany(MasterPimpinan::class, "id_user");
    }

    public function pelaksanaTugas(){
        return $this->hasMany(PelaksanaTugas::class, "id_pegawai");
    }
}
