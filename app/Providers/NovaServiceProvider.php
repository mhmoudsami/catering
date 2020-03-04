<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use App\OrderNote;
use App\Observers\OrderNoteObserver;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        
        \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields($this->settings());

        Nova::style('admin', public_path('css/dashboard-add.css'));


        Nova::serving(function () {
            OrderNote::observe(OrderNoteObserver::class);
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {
        Nova::resourcesIn(app_path('Nova'));
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * settings
     */
    protected function settings()
    {
        return [
            Text::make('Whatsapp Number', 'whatsapp_number'),
            Boolean::make('Enable Whatsapp', 'whatsapp_number_status'),
        ];
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new \App\Nova\Metrics\OrdersPerPeriod,
            new \App\Nova\Metrics\OrdersTotal,
            new \App\Nova\Metrics\ProvidersCount,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \OptimistDigital\NovaSettings\NovaSettings
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
