<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Listing;
use Faker\Generator as Faker;

$factory->define(Listing::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->name,
        'business_name' => $faker->company,
        'city' => $faker->city,
        'state' => $faker->state,
        'description' => $faker->sentence,
        'avatar' => 'avatar.png',
        'starting_package' => $faker->randomFloat(2, 100, 1000)
    ];
});
