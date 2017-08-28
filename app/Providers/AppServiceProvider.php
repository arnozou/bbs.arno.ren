<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\AuthcodeInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\AuthcodeRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class); 
        $this->app->bind(AuthcodeInterface::class, AuthcodeRepository::class); 
        $this->app->bind(CategoryInterface::class, CategoryRepository::class); 
    }
}
