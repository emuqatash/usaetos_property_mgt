<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
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
        //sharing data shares the data with every Inertia response
//        Inertia::share('user', function () {
//            return Auth::user() ? Auth::user()->with('roles')->only('id', 'name', 'roles') : null;
//        });
    }
}
