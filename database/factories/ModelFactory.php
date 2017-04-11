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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Thread::class, function(Faker\Generator $faker){
	return [
		'user_id' => function () {
			return create('App\User')->id;
		},
		'channel_id' => function () {
			return create('App\Channel')->id;
		},
		'title' => $faker->sentence,
		'body' => $faker->paragraph
	];
});

$factory->define(App\Reply::class, function(Faker\Generator $faker){
	return [
		'thread_id' => function () {
			return create('App\Thread')->id;
		},
		'user_id' => function () {
			return create('App\User')->id;
		},
		'body' => $faker->paragraph
	];
});

$factory->define(App\Channel::class, function(Faker\Generator $faker){
	$name = $faker->word;

	return [
		'name' => $name,
		'slug' => $name
	];
});