<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;
    $name = $faker->name;

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt($password), // password
        'description' => $faker->sentence(10),
        'remember_token' => Str::random(10),
        'confirmed' => true,
    ];
});

$factory->state(App\User::class, 'unconfirmed', function () {
    return [
        'confirmed' => false,
    ];
});

$factory->state(App\User::class, 'administrator', function () {
    return [
        'name' => 'admin',
    ];
});

$factory->define(App\Thread::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->create()->id;
        },

        'title' => $title,
        'body' => $faker->paragraph,
        'slug' => str_slug($title),
        'locked' => false,
    ];
});

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'thread_id' => function () {
            return factory('App\Thread')->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar'],
    ];
});


// categories
$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});

// posts
$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6),
        'body' => $faker->paragraph(10),
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'category_id' => function () {
            return factory('App\Category')->create()->id;
        },
    ];
});

// topics
$factory->define(App\Topic::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});

// post_topics
$factory->define(App\PostTopic::class, function (Faker $faker) {
    return [
        'post_id' => function () {
            return factory('App\Post')->create()->id;
        },
        'topic_id' => function () {
            return factory('App\Topic')->create()->id;
        },
    ];
});