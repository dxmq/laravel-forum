<?php

namespace App\Providers;

use App\Category;
use App\Channel;
use App\Post;
use App\Thread;
use App\Topic;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravelista\Comments\Comment;
use Laravelista\Ekko\Ekko;

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

        View::composer(['threads.index', 'threads.create'], function ($view) {
            $channel = Channel::with('threads')->get();
            $view->with('channels', $channel);
        });

        View::composer(['posts.index', 'posts.show', 'posts.edit', 'posts.create'], function ($view) {
            $categories = Category::with('posts')->get();
            $topics = Topic::with('posts')->get();

            $comments = Comment::with(['commenter', 'commentable', 'children', 'parent'])->take(4)->latest()->get();

            $view->with(['categories' => $categories, 'topics' => $topics, 'comments' => $comments]);
        });

        View::composer(['*'], function ($view) {
            $postCount = Post::count();
            $threadCount = Thread::count();
            $userCount = User::count();

            $view->with(compact('postCount', 'threadCount', 'userCount'));
        });

        $ekko = new Ekko();
        View::share('ekko', $ekko);

        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
