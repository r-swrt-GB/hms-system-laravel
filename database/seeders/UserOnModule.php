<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOnModule extends Seeder
{
    public function run()
    {
        $lecturerIds = collect([1, 2, 3, 4, 5]);
        $studentIds = collect([6, 7, 8]);
        $moduleIds = DB::table('modules')->pluck('id');

        $randomLecturerId = 1;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 1]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 1]
            );
        }

        $randomLecturerId = 1;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 1]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 1]
            );
        }

        $randomLecturerId = 1;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 2]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 2]
            );
        }

        $randomLecturerId = 5;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 1]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 1]
            );
        }

        $randomLecturerId = 5;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 3]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 3]
            );
        }

        $randomLecturerId = 2;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 1]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 2]
            );
        }

        $randomLecturerId = 3;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 3]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 3]
            );
        }

        $randomLecturerId = 4;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 3]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 3]
            );
        }
        $randomLecturerId = 2;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 5]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 5]
            );
        }

        $randomLecturerId = 3;

        DB::table('user_modules')->updateOrInsert(
            ['user_id' => $randomLecturerId, 'module_id' => 6]
        );

        $randomStudentIds = $studentIds->random(2);

        foreach ($randomStudentIds as $studentId) {
            DB::table('user_modules')->updateOrInsert(
                ['user_id' => $studentId, 'module_id' => 6]
            );
        }
    }
}
