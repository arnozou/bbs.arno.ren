<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\AuthcodeInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\TopicInterface;
use App\Repositories\Interfaces\ReplyInterface;
use App\Repositories\AuthcodeRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\TopicRepository;
use App\Repositories\ReplyRepository;

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
        $this->app->bind(TopicInterface::class, TopicRepository::class);
        $this->app->bind(ReplyInterface::class, ReplyRepository::class);
    }
}
