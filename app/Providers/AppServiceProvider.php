<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Deck;
use Illuminate\Support\Facades\Schema;

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
        Gate::define('update-deck', function (User $user, Deck $deck) {
            return $user->id === $deck->user_id;
        });

        Gate::define('access-admin', function (User $user) {
            return $user->is_admin === true;
        });

        Schema::defaultStringLength(191);
    }
}
