<?php

namespace Database\Seeders;

use App\Http\Middleware\CheckRight;
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
                'right_name' => 'Lecturer Access',
                'slug' => 'lecturer-access',
                'description' => 'Access for lecturers'
            ],
            [
                'right_name' => 'Student Access',
                'slug' => 'student-access',
                'description' => 'Access for students'
            ],
            [
                'right_name' => 'Admin Access',
                'slug' => 'admin-access',
                'description' => 'Access for admins'
            ],
            [
                'right_name' => 'Module List View Access',
                'slug' => 'module-list-view-access',
                'description' => 'View list of modules'
            ],
            [
                'right_name' => 'Module View Access',
                'slug' => 'module-view-access',
                'description' => 'View a module'
            ],
            [
                'right_name' => 'Module Create Access',
                'slug' => 'module-create-access',
                'description' => 'Create a module'
            ],
            [
                'right_name' => 'Module Update Access',
                'slug' => 'module-update-access',
                'description' => 'Update a module'
            ],
            [
                'right_name' => 'Module Delete Access',
                'slug' => 'module-delete-access',
                'description' => 'Delete a module'
            ],
            [
                'right_name' => 'Notification View Access',
                'slug' => 'notification-view-access',
                'description' => 'View notifications'
            ],
            [
                'right_name' => 'Notification Create Access',
                'slug' => 'notification-create-access',
                'description' => 'Create notifications'
            ],
            [
                'right_name' => 'Notification Update Access',
                'slug' => 'notification-update-access',
                'description' => 'Update notifications'
            ],
            [
                'right_name' => 'Notification Mark As Read Access',
                'slug' => 'notification-mark-as-read-update-access',
                'description' => 'Mark notifications as read'
            ],
            [
                'right_name' => 'Notification Delete Access',
                'slug' => 'notification-delete-access',
                'description' => 'Delete notifications'
            ],
            [
                'right_name' => 'Submission View Access',
                'slug' => 'submission-view-access',
                'description' => 'View submissions'
            ],
            [
                'right_name' => 'Submission Create Access',
                'slug' => 'submission-create-access',
                'description' => 'Create submissions'
            ],
            [
                'right_name' => 'Submission Update Access',
                'slug' => 'submission-update-access',
                'description' => 'Update submissions'
            ],
            [
                'right_name' => 'Submission Delete Access',
                'slug' => 'submission-delete-access',
                'description' => 'Delete submissions'
            ],
            [
                'right_name' => 'Assignment View Access',
                'slug' => 'assignment-view-access',
                'description' => 'View assignments'
            ],
            [
                'right_name' => 'Assignment Create Access',
                'slug' => 'assignment-create-access',
                'description' => 'Create assignments'
            ],
            [
                'right_name' => 'Assignment Mark As Read Update Access',
                'slug' => 'assignment-mark-as-read-update-update-access',
                'description' => 'Mark assignments as read and update status'
            ],
            [
                'right_name' => 'Assignment Delete Access',
                'slug' => 'assignment-delete-access',
                'description' => 'Delete assignments'
            ],
            [
                'right_name' => 'Group View Access',
                'slug' => 'group-view-access',
                'description' => 'View groups'
            ],
            [
                'right_name' => 'Group List View Access',
                'slug' => 'group-view-list-access',
                'description' => 'View list of groups'
            ],
            [
                'right_name' => 'Group Create Access',
                'slug' => 'group-create-access',
                'description' => 'Create group'
            ],
            [
                'right_name' => 'Group Update Access',
                'slug' => 'group-update-access',
                'description' => 'Update group'
            ],
            [
                'right_name' => 'Group Delete Access',
                'slug' => 'group-delete-access',
                'description' => 'Delete group'
            ],
            [
                'right_name' => 'Comment View Access',
                'slug' => 'comment-view-access',
                'description' => 'View comments'
            ],
            [
                'right_name' => 'Comment View Access',
                'slug' => 'comment-view-list-access',
                'description' => 'View all comments for submission'
            ],
            [
                'right_name' => 'Comment Create Access',
                'slug' => 'comment-create-access',
                'description' => 'Create comments'
            ],
            [
                'right_name' => 'Comment Update Access',
                'slug' => 'comment-update-access',
                'description' => 'Update comments'
            ],
            [
                'right_name' => 'Comment Delete Access',
                'slug' => 'comment-delete-access',
                'description' => 'Delete comments'
            ],
            [
                'right_name' => 'Profile View Access',
                'slug' => 'profile-view-access',
                'description' => 'View profiles'
            ],
            [
                'right_name' => 'Profile Update Access',
                'slug' => 'profile-update-access',
                'description' => 'Update profiles'
            ],
            [
                'right_name' => 'Profile Delete Access',
                'slug' => 'profile-delete-access',
                'description' => 'Delete profiles'
            ],
        ]);
    }
}
