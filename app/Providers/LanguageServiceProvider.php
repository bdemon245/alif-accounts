<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\FilamentLanguageSwitch;

class LanguageServiceProvider extends ServiceProvider
{
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
        FilamentLanguageSwitch::configureUsing(fn (FilamentLanguageSwitch $switch) => $switch->setRenderHookName('user-menu.account.after'));
    }
}
