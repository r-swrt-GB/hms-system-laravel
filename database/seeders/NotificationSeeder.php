<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'user_id' => 1,
                'module_id' => 1,
                'title' => 'Assignment Due Soon',
                'type' => 'reminder',
                'message' => 'The deadline for the "Introduction to Psychology" assignment is approaching.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'module_id' => 4,
                'title' => 'New Assignment Added',
                'type' => 'info',
                'message' => 'A new assignment, "Cognitive Science: Presentation," has been added to your module.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'module_id' => 7,
                'title' => 'Grade Submission Reminder',
                'type' => 'reminder',
                'message' => 'Remember to submit grades for the "Social Psychology" assignment.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'module_id' => 5,
                'title' => 'Student Query',
                'type' => 'support',
                'message' => 'A student has submitted a query regarding the "Developmental Psychology: Case Study" assignment.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'module_id' => 10,
                'title' => 'Upcoming Workshop',
                'type' => 'info',
                'message' => 'There is an upcoming workshop on research methods related to your module.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
