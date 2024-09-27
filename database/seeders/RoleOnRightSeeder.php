<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleOnRightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch role IDs from the database
        $adminRoleId = DB::table('roles')->where('slug', 'admin')->value('id');
        $lecturerRoleId = DB::table('roles')->where('slug', 'lecturer')->value('id');
        $studentRoleId = DB::table('roles')->where('slug', 'student')->value('id');

        // Admin rights
        DB::table('role_on_right')->insert([
            ['role_id' => $adminRoleId, 'right_id' => DB::table('rights')->where('slug', 'admin-access')->value('id')],
        ]);

        // Lecturer rights
        $lecturerRights = [
            'lecturer-access',
            'module-list-view-access',
            'module-view-access',
            'module-create-access',
            'module-update-access',
            'module-delete-access',
            'notification-view-access',
            'notification-create-access',
            'notification-update-access',
            'notification-delete-access',
            'submission-view-access',
            'submission-create-access',
            'submission-update-access',
            'submission-delete-access',
            'assignment-view-access',
            'assignment-create-access',
            'assignment-mark-as-read-update-update-access',
            'assignment-delete-access',
            'comment-view-access',
            'comment-create-access',
            'comment-update-access',
            'comment-delete-access',
            'profile-view-access',
            'profile-update-access',
            'profile-delete-access',
        ];

        foreach ($lecturerRights as $right) {
            DB::table('role_on_right')->insert([
                ['role_id' => $lecturerRoleId, 'right_id' => DB::table('rights')->where('slug', $right)->value('id')],
            ]);
        }

        // Student rights
        $studentRights = [
            'student-access',
            'module-view-access',
            'notification-view-access',
            'notification-mark-as-read-update-access',
            'submission-view-access',
            'submission-create-access',
            'submission-update-access',
            'assignment-view-access',
            'comment-view-access',
            'comment-view-list-access',
            'profile-view-access',
            'profile-update-access',
            'profile-delete-access',
        ];

        foreach ($studentRights as $right) {
            DB::table('role_on_right')->insert([
                ['role_id' => $studentRoleId, 'right_id' => DB::table('rights')->where('slug', $right)->value('id')],
            ]);
        }
    }
}
