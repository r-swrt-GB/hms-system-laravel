<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentsController extends Controller
{
    public function getAssignmentPage(Request $request, Assignment $assignment)
    {
        return Inertia::render('AssignmentPage');
    }
}
