<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'bio' => $faker->text,
        'phone' => $faker->phoneNumber,
        'twitter_username' => $faker->userName,
        'github_username' => $faker->userName,
        'avatar_status' => false,
        'status' => 'PRIVATE',
        'activated' => false
    ];
});
