<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Event Manager',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Client',
                'guard_name' => 'web',
            ],
        ]);
    }
}
