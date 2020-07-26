<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'created_by' => 1,
        'category_id' => 1,
        'title' => $faker->sentence(3),
        'synopsis' => $faker->paragraph(6),
        'image' => $faker->imageUrl()
    ];
});
