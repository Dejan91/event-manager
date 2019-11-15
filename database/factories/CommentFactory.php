<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Event;
use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'event_id' => Event::all()->random()->id,
        'user_id' => User::role('Client')->get()->random()->id,
        'body' => $faker->sentence,
    ];
});
