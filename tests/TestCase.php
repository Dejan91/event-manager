<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

//        DB::statement('PRAGMA foreign_keys=on;');

        DB::table('roles')->insert(
            [
                ['name' => 'Super Admin', 'guard_name' => 'web'],
                ['name' => 'Event Manager', 'guard_name' => 'web'],
                ['name' => 'Client', 'guard_name' => 'web'],
            ]
        );

        DB::table('countries')->insert(
            [
                ['name' => 'Serbia'],
                ['name' => 'Italy'],
                ['name' => 'France'],
                ['name' => 'Germany'],
            ]
        );
    }

}
