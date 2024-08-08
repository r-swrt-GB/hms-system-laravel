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
        // Admin role has all rights
        $adminRoleId = DB::table('roles')->where('slug', 'admin')->value('id');
        $rights = DB::table('rights')->pluck('id');

        foreach ($rights as $rightId) {
            DB::table('role_on_right')->insert([
                'role_id' => $adminRoleId,
                'right_id' => $rightId,
            ]);
        }

        // Lecturer role (view videos, provide feedback, assign marks, create-assignments)
        $lecturerRoleId = DB::table('roles')->where('slug', 'lecturer')->value('id');
        DB::table('role_on_right')->insert([
            ['role_id' => $lecturerRoleId, 'right_id' => DB::table('rights')->where('slug', 'view-videos')->value('id')],
            ['role_id' => $lecturerRoleId, 'right_id' => DB::table('rights')->where('slug', 'provide-feedback')->value('id')],
            ['role_id' => $lecturerRoleId, 'right_id' => DB::table('rights')->where('slug', 'assign-marks')->value('id')],
            ['role_id' => $lecturerRoleId, 'right_id' => DB::table('rights')->where('slug', 'create-assignments')->value('id')],
        ]);

        // Student role (view videos, upload videos)
        $studentRoleId = DB::table('roles')->where('slug', 'student')->value('id');
        DB::table('role_on_right')->insert([
            ['role_id' => $studentRoleId, 'right_id' => DB::table('rights')->where('slug', 'upload-videos')->value('id')],
            ['role_id' => $studentRoleId, 'right_id' => DB::table('rights')->where('slug', 'view-videos')->value('id')],
        ]);
    }
}
