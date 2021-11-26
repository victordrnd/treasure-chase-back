<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'filiere',
        'phone',
        'code',
        'token',
        'is_cotisant',
        'password',
        'room_id',
        'panier_id',
        'taille',
        'poids',
        'pointure',
        'is_allowed',
        'n_cheque',
        'is_bde',
        'is_liste',
        'is_surf',
        'comments'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'email',
        'token',
        'is_admin',
        'is_allowed',
        'created_at',
        'updated_at',
        'comments'
    ];


    public function panier(){
        return $this->belongsTo(Panier::class);
    }

    public function billet(){
        return $this->hasOne(Pumpkin::class, "email", "email");
    }


}
