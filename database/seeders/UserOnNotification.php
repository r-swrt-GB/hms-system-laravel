<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOnNotification extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = DB::table('notifications')->get();

        $studentIds = collect([5, 6, 7, 8]);

        foreach ($notifications as $notification) {
            $randomStudentIds = $studentIds->random(2);

            foreach ($randomStudentIds as $studentId) {
                DB::table('user_on_notification')->insert([
                    'user_id' => $studentId,
                    'notification_id' => $notification->id,
                ]);
            }
        }
    }
}
