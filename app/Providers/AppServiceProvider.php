<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Pagination\Paginator::useBootstrapFive();
        
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            // Super Admin voit tout
            if ($user->hasRole('Super Admin')) {
                return true;
            }

            // Pour les autres, vérifier la permission via le rôle
            if ($user->roles->isNotEmpty()) {
                $role = $user->roles->first();
                if ($role->permissions()->where('name', $ability)->exists()) {
                    return true;
                }
            }

            return null; // passe au gate normal
        });

        \App\Models\Ecole::observe(\App\Observers\EcoleObserver::class);
    }
}
