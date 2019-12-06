<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::role('Client')->get()->random(20);

        foreach ($users as $user) {
            Auth::login($user);

            factory('App\Event', rand(1, 2))->create()->each(function($event) {
                factory('App\Comment', rand(10, 26))->create([
                    'user_id' => auth()->id(),
                    'event_id' => $event->id,
                ]);
            });
        }
    }
}
