<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Pages\Actions\Action;
use App\Http\Livewire\SwitchLocale;
use Illuminate\Support\Facades\App;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Filament\Pages\Actions\LocaleSwitcher;

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
        $labels = new LabelProvider;
        $labels->autoTranslate();
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');

            // // Using Laravel Mix
            // Filament::registerTheme(
            //     mix('css/filament.css'),
            // );
        });
        Filament::registerUserMenuItems([
            // ...
            UserMenuItem::make()
            ->label(__('Language'))
            ->url('/toggle-language')
            ->icon('heroicon-s-globe-alt'),
        ]);
    }
}
