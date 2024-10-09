<?php

namespace App\Http\Controllers;

use App\Http\Classes\Management\UserManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentManagementController extends Controller
{
    public function index(Request $request)
    {
        $studentUsers = UserManagement::getAllStudents();

        return Inertia::render('Management/StudentManagementPage', ['appBarHeader' => 'Student Management', 'studentUsers' => $studentUsers]);
    }
}
