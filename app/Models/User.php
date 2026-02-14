<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $primaryKey = 'id_user';
    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'users';

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTS AUTORISÉS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'prenom',
        'email',
        'telephone',
        'password',
        'role'
    ];

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTS CACHÉS
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'ewrwe',
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS RÔLES
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function chauffeur()
    {
        return $this->hasOne(Chauffeur::class);
    }

    public function passager()
    {
        return $this->hasOne(Passager::class);
    }

 
    // public function portefeuille()
    // {
    //     return $this->hasOne(Portefeuille::class);
    // }
    /*
    |--------------------------------------------------------------------------
    | RELATION PORTEFEUILLE
    |--------------------------------------------------------------------------
    */

   

    /*
    |--------------------------------------------------------------------------
    | OTP
    |--------------------------------------------------------------------------
    */

    public function otps()
    {
        return $this->hasMany(LoginOtp::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function isChauffeur(): bool
    {
        return $this->role === 'CHAUFFEUR';
    }

    public function isPassager(): bool
    {
        return $this->role === 'PASSAGER';
    }
}
