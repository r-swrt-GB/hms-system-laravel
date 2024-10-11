<?php

namespace App\Http\Controllers;

use App\Http\Classes\Management\UserManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LecturerManagementController extends Controller
{
    public function index(Request $request)
    {
        $lecturerUsers  = UserManagement::getAllLecturers();
        return Inertia::render('Management/LecturerManagementPage', ['appBarHeader' => 'Lecturer Management', 'lecturerUsers' => $lecturerUsers]);
    }
}
