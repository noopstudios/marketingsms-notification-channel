<?php

namespace Noopstudios\MarketingSMS\Providers;
use Illuminate\Support\ServiceProvider;
use Noopstudios\MarketingSMS\marketingSMS;

class MarketingSMSProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function register(){
        $this->app->singleton(marketingSMS::class, function ($app) {
            if(empty($app['config']['marketing_sms.api_token'])){
                throw new \Exception('You must set the marketing_sms.api_token config value');
            }

            return new marketingSMS($app['config']['marketing_sms.api_token'], $app['config']['marketing_sms.sandbox_url'] ?? null);
        });
    }

    public function provides()
    {
        return [marketingSMS::class];
    }
}