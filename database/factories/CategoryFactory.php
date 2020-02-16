<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Post\Category;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->sentence;
    $slug = Str::slug($name);
    return [
        'name' => $name,
        'slug' => $slug,
        'body' => $faker->text(40),
    ];
});
