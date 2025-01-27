<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => true,
    ];
});

$factory->state(App\User::class, 'unconfirmed', function () {
    return ['confirmed' => false];
});

$factory->state(App\User::class, 'administrator', function () {
    return ['name' => 'JohnDoe'];
});

$factory->define(App\Thread::class, function (Faker\Generator $faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->create()->id;
        },
        'title' => $title,
        'body' => $faker->text,
        'visits' => 0,
        'slug' => str_slug($title),
        'locked' => false,
    ];
});

$factory->define(App\Channel::class, function (Faker\Generator $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
    ];
});

$factory->define(App\Reply::class, function (Faker\Generator $faker) {
    return [
        'thread_id' => function () {
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body' => $faker->text,
    ];
});

$factory->define(DatabaseNotification::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar'],
    ];
});
