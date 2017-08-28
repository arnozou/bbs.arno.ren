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
use Faker\Generator as Faker;
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'mobile' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        // 'remember_token' => str_random(10),
    ];
});

$factory->define(App\UserInfo::class, function (Faker $faker) {
    return [
        'user_id'    => function () {
            return factory(User::class)->create()->id;
        },
        'real_name'   => $faker->lastName,
        'nick_name'   => $faker->firstName,
        'avatar_url'  => $faker->imageUrl(400, 400),
        'intro'       => $faker->paragraph,
    ];
});

