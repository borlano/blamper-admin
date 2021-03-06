<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $widgets = [
        \app\Admin\Widgets\Navbar::class,
    ];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \URL::forceScheme('https');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Регистрация виджетов в реестре
        /** @var WidgetsRegistryInterface $widgetsRegistry */
        $widgetsRegistry = $this->app[\SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface::class];

        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}
