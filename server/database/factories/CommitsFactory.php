<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Commits\Models\Commit;
use App\Modules\Repositories\Models\Repository;
use Faker\Generator as Faker;

$factory->define(Commit::class, function (Faker $faker) {
    return [
        'sha' => $faker->unique()->word,
        'repository_id' => factory(Repository::class)->create(),
        'description' => $faker->text,
        'author' => $faker->email,
        'committed_at' => $faker->date(),
    ];
});
