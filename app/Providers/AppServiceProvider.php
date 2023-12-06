<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use App\Filament\Resources\UserResource;

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
        //

        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('My Profile'), //ToDo
                    // ->url(UserResource::getUrl('edit',['record'=> auth()->user()])),
                // ...
            ]);
        });

    }
}
