<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        // Share unread message count with all views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $unreadCount = \App\Models\Message::where('receiver_id', Auth::user()->uid)
                    ->where('is_read', false)
                    ->count();
                $view->with('unreadMessagesCount', $unreadCount);
            } else {
                $view->with('unreadMessagesCount', 0);
            }
        });
    }
}
