<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utils\AliyunSms;
// use Log;
class SmsServiceProvider extends ServiceProvider
{

    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Log::info(__FILE__);
        // Log::info(print_r($this->app['config']->get('aliyun', []), 1));
        // Log::debug(config('aliyun.sms'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    
    public function register()
    {
        $this->app->singleton(AliyunSms::class, function($api) {
            return new AliyunSms(
                config('aliyun.sms.AccessKeyId'),
                config('aliyun.sms.AccessKeySecret')
            );
        });
        $this->registerConfig();
    }

    protected function registerConfig()
    {
       
    }

    public function provides()
    {
        return [AliyunSms::class];
    }
}
