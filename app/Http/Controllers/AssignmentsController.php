<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentsController extends Controller
{

    public function getCreateAssignmentPage(Request $request)
    {
        return Inertia::render('Assignments');
    }

}
