<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('cache.service', function ($app) {
            return new \App\Services\Cache\CacheService();
        });
    }

    public function boot()
    {
        // Добавляем конфигурацию для определения типа хостинга
        $this->app['config']->set('app.free_hosting', env('FREE_HOSTING', false));
    }
}