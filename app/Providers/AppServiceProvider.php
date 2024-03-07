<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        //
        // view()->composer(
        //     'layouts.main-header',
        //     function ($view) {
        //         $user =Auth::user();
        //         $notifications= $user->notifications;
        //         $view->with('notifications', $notifications);
        //     }
        // );
    }
}
