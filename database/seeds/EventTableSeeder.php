<?php

use App\User;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Event', 30)->create()->each(function($event) {
            factory('App\Comment', 20)->create([
                'event_id' => $event->id,
                ]);
        });
    }
}
