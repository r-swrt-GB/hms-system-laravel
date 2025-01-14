<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ModuleSeeder::class,
            AssignmentsSeeder::class,
            RoleSeeder::class,
            RightSeeder::class,
            RoleOnRightSeeder::class,
            UserOnRole::class,
            UserOnModule::class,
            UserOnAssignment::class,
            UserOnNotification::class,
        ]);
    }
}
