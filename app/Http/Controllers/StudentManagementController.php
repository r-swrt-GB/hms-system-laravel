<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentManagementController extends Controller
{
    public function getStudentManagementPage(Request $request)
    {
        return Inertia::render('StudentManagementPage');
    }
}
