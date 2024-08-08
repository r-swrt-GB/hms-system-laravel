<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rights')->insert([
            [
                'right_name' => 'View Videos',
                'slug' => 'view-videos',
                'description' => 'Permission to view uploaded videos.'
            ],
            [
                'right_name' => 'Upload Videos',
                'slug' => 'upload-videos',
                'description' => 'Permission to upload videos.'
            ],
            [
                'right_name' => 'Provide Feedback',
                'slug' => 'provide-feedback',
                'description' => 'Permission to provide feedback on videos.'
            ],
            [
                'right_name' => 'Assign Marks',
                'slug' => 'assign-marks',
                'description' => 'Permission to assign marks to videos.'
            ],
            [
                'right_name' => 'Create Assignments',
                'slug' => 'create-assignments',
                'description' => 'Permission to create new assignments.'
            ],
            [
                'right_name' => 'Admin Access',
                'slug' => 'admin-access',
                'description' => 'Full access to all system features and settings.'
            ],
        ]);
    }
}
