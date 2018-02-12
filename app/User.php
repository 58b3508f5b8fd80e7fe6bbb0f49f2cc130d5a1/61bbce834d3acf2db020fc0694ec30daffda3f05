<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;

    use Searchable;
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
}


