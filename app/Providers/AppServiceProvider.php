<?php

namespace App\Providers;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
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
        CreateAction::configureUsing(function (CreateAction $action): void {
            $action->modalWidth('md')
                ->icon('heroicon-o-plus');
        });

        EditAction::configureUsing(function (EditAction $action): void {
            $action->modalWidth('md')
                ->icon('heroicon-o-pencil');
        });

        ViewAction::configureUsing(function (ViewAction $action): void {
            $action->modalWidth('md');
        });

        DeleteAction::configureUsing(function (DeleteAction $action): void {
            $action->icon('heroicon-o-trash');
        });
    }
}
