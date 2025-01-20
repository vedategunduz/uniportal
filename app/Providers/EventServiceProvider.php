<?php

namespace App\Providers;

use App\Listeners\LogFailedLogin;
use App\Listeners\LogLoginHistory;
use App\Listeners\LogLogoutHistory;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogLoginHistory::class,
        ],
        Logout::class => [
            LogLogoutHistory::class,
        ],
        Failed::class => [
            LogFailedLogin::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
