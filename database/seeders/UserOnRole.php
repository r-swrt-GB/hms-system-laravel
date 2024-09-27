<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOnRole extends Seeder
{
    public function run()
    {
        // Get the 'Admin' role ID
        $adminRoleId = DB::table('roles')->where('slug', 'student')->value('id');

        // Get the IDs of the first 4 users
        $userIds = DB::table('users')->limit(4)->pluck('id');

        // Insert into the user_role table
        foreach ($userIds as $userId) {
            DB::table('user_role')->insert([
                'user_id' => $userId,
                'role_id' => $adminRoleId,
            ]);
        }
    }
}
