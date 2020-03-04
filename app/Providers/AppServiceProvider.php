<?php

namespace App\Providers;

use App\OrderNote;
use App\Observers\OrderNoteObserver;
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
        // OrderNote::observe(OrderNoteObserver::class);
    }
}
