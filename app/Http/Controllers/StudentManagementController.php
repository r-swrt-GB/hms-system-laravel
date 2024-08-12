<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentManagementController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('StudentManagementPage');
    }
}
