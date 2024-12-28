<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {// Using a closure
        View::composer('layouts.header', function ($view) {
            $user = User::find(auth()->id()); // Get the authenticated user
            $view->with('currentUser', $user);
        });

        // Initialize empty sidebarItems for all views
        View::composer('components.sidebar', function ($view) {
            if (!isset($view->getData()['sidebarItems'])) {
                $view->with('sidebarItems', []);
            }
        });
    }
}
