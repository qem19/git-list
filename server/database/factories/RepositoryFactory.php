<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Repositories\Models\Repository;
use App\Modules\Vendors\Models\Vendor;
use Faker\Generator as Faker;

$factory->define(Repository::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'vendor_id' => factory(Vendor::class)->create()
    ];
});
