<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Post\Category;

$factory->define(Category::class, function (Faker $faker) {

    $name = $faker->sentence;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'body' => $faker->text(100),
    ];
});
