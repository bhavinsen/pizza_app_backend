<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'sku'  => $faker->word,
        'detail' => $faker->paragraph,
        'price'  => '50',
        'slug' => 'https://images.dominos.co.in/updated_paneer_makhani.jpg'
    ];
});
