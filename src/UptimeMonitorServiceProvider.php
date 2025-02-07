<?php

namespace Rudev\UptimeMonitor;

use Illuminate\Support\ServiceProvider;

class UptimeMonitorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/uptime-monitor.php', 'uptime-monitor');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/uptime-monitor.php' => config_path('uptime-monitor.php'),
            ], 'config');

            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            $this->commands([
                \Rudev\UptimeMonitor\Commands\CheckUptime::class,
                \Rudev\UptimeMonitor\Commands\AdjustVendorSubscriptions::class,
            ]);
        }
    }
}
