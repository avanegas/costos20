<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'user_id' => rand(1,8)
    ];
});
