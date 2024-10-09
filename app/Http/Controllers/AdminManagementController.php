<?php

namespace App\Http\Controllers;

use App\Http\Classes\Management\UserManagement;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminManagementController extends Controller
{
    public function index(Request $request)
    {
        $adminUsers  = UserManagement::getAllAdmins();

        return Inertia::render('Management/AdminManagementPage', ['appBarHeader' => 'Admin Management', 'adminUsers' => $adminUsers]);
    }
}
