<?php

use Illuminate\Database\Seeder;

class MailTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mail_types')->insert([
            [
                'name' => 'event_daily',
            ],
            [
                'name' => 'event_weekly',
            ],
        ]);
    }
}
