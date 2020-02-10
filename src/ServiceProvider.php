<?php


namespace Fengjian199308\Weather;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Weather::class, function () {
            return new Weather('services.weather.key');
        });

        $this->app->alias(Weather::class, 'weather');
    }

    public function providers()
    {
        return [Weather::class, 'weather'];
    }
}