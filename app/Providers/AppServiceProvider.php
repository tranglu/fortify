<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView(function () {
            return view('auth.login');
        });
        Fortify::registerView(function () {
            return view('auth.register');
        });
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.passwords.email');
        });
        Fortify::resetPasswordView(function ($request) {
            $token = $request->route()->parameter('token');
            return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
        });
        Fortify::verifyEmailView(function () {
            return view('auth.verify');
        });
        Fortify::confirmPasswordView(function () {
            return view('auth.passwords.confirm');
        });
    }
}
