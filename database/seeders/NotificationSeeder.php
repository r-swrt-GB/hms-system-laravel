<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'user_id' => 1, // assuming user with id 1 exists
                'module_id' => 1, // assuming module with id 1 exists
                'title' => 'New Module Update',
                'type' => 'info',
                'message' => 'A new update has been applied to the module.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'module_id' => 2,
                'title' => 'Scheduled Maintenance',
                'type' => 'warning',
                'message' => 'There will be a scheduled maintenance at midnight.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'module_id' => 3,
                'title' => 'Module Deprecated',
                'type' => 'alert',
                'message' => 'This module will no longer be supported after the next update.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
