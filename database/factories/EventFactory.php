<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Event;
use App\Country;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $date = Carbon::now();

    return [
        'user_id' => User::role('Event Manager')->get()->random()->id,
        'country_id' => Country::all()->random()->id,
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'image_path' => null,
        'start_date' => $date->addDay(rand(1, 20))->format('Y-m-d'),
        'end_date' => $date->addDay()->format('Y-m-d'),
    ];
});
