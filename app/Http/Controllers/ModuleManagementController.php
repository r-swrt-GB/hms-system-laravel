<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuleManagementController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Management/ModuleManagementPage');
    }

    public function read(Request $request, Module $module)
    {
        return response()->json(['module' => $module]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'module_name' => 'required',
            'code' => 'required'
        ]);

        $module = Module::create($validatedData);

        return response()->json(['module' => $module, 'message' => 'Module created successfully.']);
    }

    public function update(Request $request, Module $module)
    {
        $validatedData = $request->validate([
            'module_name' => 'required',
            'code' => 'required'
        ]);

        $module->update($validatedData);

        return response()->json(['message' => 'Module updated successfully.']);
    }

    public function delete(Request $request, Module $module)
    {
        $module->delete();

        return response()->json(['message' => 'Module deleted successfully.']);
    }
}
