<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Vendors\Models\Vendor;
use Faker\Generator as Faker;

$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});
