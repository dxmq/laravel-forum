<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', 'IndexController@index')->name('posts.index');

Route::get('threads', 'ThreadsController@index')->name('threads');
Route::get('threads/create','ThreadsController@create');
Route::get('threads/{channel}/thread','ThreadsController@index');
Route::get('threads/{thread}','ThreadsController@show')->name('threads.show');
Route::patch('threads/{channel}/{thread}', 'ThreadsController@update');
Route::delete('threads/{thread}', 'ThreadsController@destroy');
Route::post('threads','ThreadsController@store');
Route::get('/threads/{thread}/replies','RepliesController@index');
Route::post('/threads/{thread}/replies','RepliesController@store');


Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}','LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');


Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

// 订阅与取消订阅
Route::post('/threads/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');


Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Route::put('/profiles/{user}', 'ProfilesController@update');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}','UserNotificationsController@destroy');

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index');


Route::get('api/users', 'Api\UsersController@index');
Route::get('/users/send_verification_mail', 'UsersController@sendVerificationMail')->name('users.send-verification-mail'); // 发送邮件
Route::post('user/{id}/fan', 'UsersController@fan');
Route::post('user/{id}/unfan', 'UsersController@unfan');

// posts
Route::prefix('posts')->group(function () {
    // 创建文章
    Route::get('/create','PostsController@create');
    // 查看文章
    Route::get('/{post}','PostsController@show')->name('posts.show');
    Route::post('/store','PostsController@store');
    // 更新文章
    Route::get('/{post}/edit','PostsController@edit');
    Route::put('/{post}','PostsController@update');
    // 删除文章
    Route::get('/{id}/delete','PostsController@destroy');

    // 某个分类下的文章
    Route::get('/categories/{category}', 'PostsController@category');

    // 某个专题下的文章
    Route::get('/topics/{topic}', 'PostsController@topic');
});

Route::middleware('auth:web')->group(function () {
    Route::get('api/posts/is-zan/{id}', 'Api\PostsController@isZan');
    Route::get('api/posts/zan-or-cancel/{id}', 'Api\PostsController@zanOrCancel');

//    Route::post('api/posts/{id}/comment', 'Api\PostsController@comment');
});


// github 登录
Route::get('/oauth/github', 'Auth\GithubController@redirectToProvider')->name('github');
Route::get('/oauth/github/callback', 'Auth\GithubController@handleProviderCallback');

Auth::routes();
