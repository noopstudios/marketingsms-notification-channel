<?php

namespace Noopstudios\MarketingSMS;
use Illuminate\Support\ServiceProvider;
use Noopstudios\MarketingSMS\marketingSMS;

class MarketingSMSProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(){
        $this->app->when(MarketingSMSChannel::class)
            ->needs(marketingSMS::class)
            ->give(function () {
                if(empty(config('marketing_sms.api_token'))){
                    throw new \Exception('You must set the marketing_sms.api_token config value');
                }

                return new marketingSMS(config('marketing_sms.api_token'), config('marketing_sms.sandbox_url') ?? null);
            });
    }
}
