<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;


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
        if(strlen($username)>=32) {
            return $this->where('wallet_id', $username)->first();
        }
        return $this->where('name', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->pin);
    }
}


