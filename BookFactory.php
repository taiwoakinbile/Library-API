<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'isbn' => $faker->text(12),
        'title' => $faker->text(100),
        'author' => $faker->text(150)
    ];
});
