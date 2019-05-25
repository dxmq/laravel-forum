<?php

namespace App\Providers;

use App\Category;
use App\Channel;
use App\Topic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh');
        /*View::share('channels', \App\Channel::all()); // 共享channel数据*/

        View::composer('*', function ($view) {
           $channel = Cache::rememberForever('channels', function () {
               return Channel::all();
           });
           $view->with('channels', $channel);
        });

        View::composer(['posts.*'], function ($view) {
            $categories = Cache::rememberForever('categories', function () {
                return Category::with('posts')->get();
            });

            $topics = Cache::rememberForever('topics', function () {
                return Topic::with('posts')->get();
            });

            $view->with(['categories' => $categories, 'topics' => $topics]);
        });



        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
