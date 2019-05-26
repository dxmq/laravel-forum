<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->get('/posts', 'PostsController@index');
    $router->get('/posts/{post}', 'PostsController@show');
    $router->delete('/posts/{id}', 'PostsController@destroy');

    $router->resource('categories', 'CategoriesController');
    $router->resource('topics', 'TopicsController');
    $router->resource('comments', 'CommentsController', [
        'only' => ['index', 'show', 'destroy']
    ]);

    $router->get('/threads', 'ThreadsController@index');
    $router->get('/threads/{thread}', 'ThreadsController@show');
    $router->delete('/threads/{id}', 'ThreadsController@destroy');

    $router->get('/channels', 'ChannelsController@index');
    $router->get('/channels/{channel}', 'ChannelsController@show');
    $router->delete('/channels/{id}', 'ChannelsController@destroy');
});
