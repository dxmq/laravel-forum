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
use Laravelista\Comments\Comment;

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

        View::composer(['threads.index'], function ($view) {
           /*$channel = Cache::rememberForever('channels', function () {
               return Channel::all();
           });*/
           $channel = Channel::with('threads')->get();
           $view->with('channels', $channel);
        });

        View::composer(['posts.index', 'posts.show', 'posts.category', 'posts.topic'], function ($view) {
            /*$categories = Cache::rememberForever('categories', function () {
                return Category::with('posts')->get();
            });

            $topics = Cache::rememberForever('topics', function () {
                return Topic::with('posts')->get();
            });*/
            $categories = Category::with('posts')->get();
            $topics = Topic::with('posts')->get();

            $comments = Comment::with(['commenter', 'commentable', 'children', 'parent'])->latest()->paginate(3);

            $view->with(['categories' => $categories, 'topics' => $topics, 'comments' => $comments]);
        });



        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
