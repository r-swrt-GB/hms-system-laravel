<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOnModule extends Seeder
{
    public function run()
    {
        $lecturerIds = collect([1, 2, 3, 4]);
        $studentIds = collect([5, 6, 7, 8]);
        $moduleIds = DB::table('modules')->pluck('id');

        foreach ($moduleIds as $moduleId) {
            $randomLecturerId = $lecturerIds->random();

            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $randomLecturerId, 'module_id' => $moduleId]
            );

            $randomStudentIds = $studentIds->random(2);

            foreach ($randomStudentIds as $studentId) {
                DB::table('user_modules')->updateOrInsert(
                    ['user_id' => $studentId, 'module_id' => $moduleId]
                );
            }
        }
    }
}
