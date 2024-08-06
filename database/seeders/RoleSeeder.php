<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'slug' => 'admin',
                'description' => 'The project owner and/or sponsor with unrestricted access to all components of the system.'
            ],
            [
                'role_name' => 'Lecturer',
                'slug' => 'lecturer',
                'description' => 'Lecturers within the faculty who will provide feedback and review videos.'
            ],
            [
                'role_name' => 'Student',
                'slug' => 'student',
                'description' => 'Students within the faculty who will upload videos and receive feedback.'
            ],
        ]);
    }
}
