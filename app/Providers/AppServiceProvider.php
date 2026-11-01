<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        Paginator::useBootstrapFive();

        // Dietro il proxy di un hosting condiviso Laravel può non accorgersi dell'HTTPS
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
        // Composer e non View::share: la query non deve girare a ogni avvio, altrimenti migrate fallisce su un database vuoto
        View::composer('components.navbar', function ($view) {
            $view->with('categories', Category::all());
        });

        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });

        RateLimiter::for('subscriptions', function (Request $request) {
            return Limit::perMinute(20)->by($request->user()->id);
        });
    }
}
