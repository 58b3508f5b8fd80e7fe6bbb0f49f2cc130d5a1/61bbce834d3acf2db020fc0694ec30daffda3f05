<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies
        = [
            'App\Model' => 'App\Policies\ModelPolicy',
        ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        //

        Passport::tokensCan([
            'details'       => 'Access your details',
            'transactions'  => 'Perform transactions on your account',
            'registrations' => 'Will make deductions from your account for any registrations'
        ]);
    }
}
