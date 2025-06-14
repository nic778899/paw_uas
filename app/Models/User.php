<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Models\DataPribadi;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'password_confirmation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    public function absensis(){
        return $this->hasMany(Absensi::class);
    }

    public function data_pribadi(){
        return $this->hasOne(DataPribadi::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(JabatanOrganisasi::class);
    }
    public function jabatanOrganisasi()
    {
        return $this->belongsTo(JabatanOrganisasi::class, 'jabatan_organisasi_id');
    }
}
