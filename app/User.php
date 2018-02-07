<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    const VERIFIED_USER   = '1';
    const UNVERIFIED_USER = '0';
    const ADMIN_USER   ='true';
    const REGULAR_USER ='false';
    protected $table = 'users';
    public $transformer = UserTransformer::class;

    protected $fillable = [
        'name','email',
        'password','verified',
        'verification_token','admin',
    ];
    protected $hidden = [
        'password', 'remember_token',
        'verification_token',
    ];

    public function isVerified(){
        return $this->verified === User::VERIFIED_USER;
    }
    public function isAdmin(){
        return $this->admin == User::ADMIN_USER;
    }

    static function generateVerificationCode(){
        return str_random(40);
    }

}
