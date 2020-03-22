<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\Oferta\Oferta;

$factory -> define( Oferta::class, function (Faker $faker) {
    $name = $faker->sentence(4, true);
    $descripcion = $faker->sentence(6, true);
    $precio = $faker->randomFloat(2, 10, 100);
    return [
            'user_id'     => rand(1, 10),
            'name'        => $name,
            'unidad'      => $faker->word,
            'descripcion' => $descripcion,
            'stock'       => rand(1, 10),
            'precio'      => $precio,
            'file'        => 'oferta.png',
            'status'      => true
    ];
});
