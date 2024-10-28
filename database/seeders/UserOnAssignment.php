<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOnAssignment extends Seeder
{
    public function run()
    {
        $assignments = DB::table('assignments')->get();

        foreach ($assignments as $assignment) {
            $moduleUsers = DB::table('user_modules')
                ->where('module_id', $assignment->module_id)
                ->pluck('user_id');

            foreach ($moduleUsers as $userId) {
                DB::table('user_assignments')->insert([
                    'user_id' => $userId,
                    'assignment_id' => $assignment->id,
                ]);
            }
        }
    }
}
