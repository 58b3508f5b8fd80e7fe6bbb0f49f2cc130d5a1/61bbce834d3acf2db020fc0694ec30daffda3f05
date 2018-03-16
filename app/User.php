<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
=======
>>>>>>> 7482e2606e5a637078a50a4885642a5ae9c274bc

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name',
            'first_name',
            'last_name',
            'email',
            'password',
            'wallet_id',
            'pin',
            'account_number',
            'wallet_address',
            'private_key',
            'type',
            'access_level',
            'status',
            'avatar'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    public function findForPassport($username)
    {
        return $this->where('wallet_id', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->pin);
    }
}


