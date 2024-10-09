<?php

namespace App\Http\Classes\Management;

use App\Models\User;

class UserManagement
{
    public static function getAllAdmins()
    {
        $allUsers = User::all();

        return $allUsers->filter(function ($user) {
            return $user->hasRole('admin');
        });

    }

    public static function getAllLecturers()
    {
        $allUsers = User::all();

        return $allUsers->filter(function ($user) {
            return $user->hasRole('lecturer');
        });

    }

    public static function getAllStudents()
    {
        $allUsers = User::all();

        return $allUsers->filter(function ($user) {
            return $user->hasRole('student');
        });
    }
}
