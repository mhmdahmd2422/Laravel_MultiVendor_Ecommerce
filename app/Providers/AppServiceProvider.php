<?php

namespace App\Providers;

use App\Models\FooterData;
use App\Models\GeneralSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrap();

        //start general settings
        $generalSettings = GeneralSetting::first();
        $infoSettings = FooterData::first();
        //Set TimeZone
        Config::set('app.timezone', $generalSettings->timezone);
//        //Set App name
        Config::set('app.name', $generalSettings->site_name);
        //share currency to views
        View::composer('*', function ($view) use ($infoSettings, $generalSettings){
            $view->with(
                [
                    'settings' => $generalSettings,
                    'info' => $infoSettings,
                ]
            );
        });
        View::composer(['frontend.dashboard.address.*', 'frontend.pages.checkout'], function ($view){
            $view->with('countries', config('countries.countries'));
        });
    }
}
