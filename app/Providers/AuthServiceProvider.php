<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::viaRequest('auth-token', function (Request $request) {
            return User::where('api_token', $request->string('api-token'))->first();
        });

        Gate::define('admin', function (User $user) {
            return $user->role === Role::ADMIN->value;
        });

        Gate::define('cleaning', function (User $user) {
            return $user->role === Role::CLEANING->value;
        });

        Gate::define('car-park', function (User $user) {
            return $user->role === Role::CAR_PARK->value;
        });
    }
}
