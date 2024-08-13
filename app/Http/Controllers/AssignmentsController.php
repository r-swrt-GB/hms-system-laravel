<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Assignments/AssignmentsPage');
    }

    public function getAssignmentPage(Request $request, Assignment $assignment)
    {
        return Inertia::render('Assignments/AssignmentPage');
    }

    public function getCreateAssignmentPage(Request $request)
    {
        return Inertia::render('Assignments/CreateAssignmentsPage');
    }
}
