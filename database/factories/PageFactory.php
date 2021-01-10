<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\Page;
use Illuminate\Support\Str;

$factory->define(Page::class, function (Faker $faker) {

    $name = $faker->sentence;
  
    return [
        'title'     => $name,
        'slug'      => Str::slug($name),
        'body'      => $faker->text(100),
        'parent_id' => rand(1, 10),        
    ];
});
