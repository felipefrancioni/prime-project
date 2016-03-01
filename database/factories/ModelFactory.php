<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(SdcProject\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(SdcProject\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'responsible' => $faker->name,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence
    ];
});

$factory->define(SdcProject\Entities\Project::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => rand(1, 10),
        'client_id' => rand(1, 10),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'progress' => rand(1, 100),
        'status' => rand(1, 3),
        'due_date' => $faker->date()
    ];
});

$factory->define(SdcProject\Entities\ProjectTask::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'project_id' => rand(1, 10),
        'start_date' => $faker->date(),
        'due_date' => $faker->date(),
        'status' => rand(1, 3),
    ];
});


$factory->define(SdcProject\Entities\ProjectMember::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1, 10),
        'user_id' => rand(1, 10)
    ];
});