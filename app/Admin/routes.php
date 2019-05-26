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
});
