<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

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
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            return config('app.url').'/reset-password?token='.$token.'&email='.urlencode($notifiable->email);
        });

        RateLimiter::for('smsattemp', function (Request $request) {
            return Limit::perMinute(3)->response(function() {
                return new Response(['error'=>'Too many attempts'],429);
            });
        });
    }
}
