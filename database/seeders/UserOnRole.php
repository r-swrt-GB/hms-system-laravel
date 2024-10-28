<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOnRole extends Seeder
{
    public function run()
    {
        $adminRoleId = DB::table('roles')->where('slug', 'admin')->value('id');

        $userIds = [1, 2, 3, 4, 5];

        foreach ($userIds as $userId) {
            DB::table('user_role')->insert([
                'user_id' => $userId,
                'role_id' => $adminRoleId,
            ]);
        }

        $studentRoleId = DB::table('roles')->where('slug', 'student')->value('id');

        $userIds = [6, 7, 8,];

        foreach ($userIds as $userId) {
            DB::table('user_role')->insert([
                'user_id' => $userId,
                'role_id' => $studentRoleId,
            ]);
        }

        $lecturerRoleId = DB::table('roles')->where('slug', 'lecturer')->value('id');

        $lecturers = [9, 10,];

        foreach ($lecturers as $userId) {
            DB::table('user_role')->insert([
                'user_id' => $userId,
                'role_id' => $lecturerRoleId,
            ]);
        }
    }
}
