<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ModuleManagementController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Management/ModuleManagementPage');
    }

    public function list(Request $request)
    {
        try {
            $modules = Module::all();

            if ($modules->isEmpty()) {
                return response()->json(['message' => 'No modules found', 'modules' => []], 404);
            }

            return response()->json(['modules' => $modules]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserModules(Request $request)
    {

        $user = Auth::user();
        $modules = $user->modules()->get();
        return response()->json(['modules' => $modules]);
    }

    public function read(Request $request, $moduleId)
    {
        try {
            $module = Module::findOrFail($moduleId);
            return response()->json(['module' => $module]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Module not found',
                'message' => "No module found with id {$moduleId}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists'
            ], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'module_name' => 'required|string|max:255',
                'code' => 'required|string|unique:modules,code'
            ]);

            $module = Module::create($validatedData);

            return response()->json(['module' => $module, 'message' => 'Module created successfully.'], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => 'An error occurred while creating the module. Please try again.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists'
            ], 500);
        }
    }

    public function update(Request $request, $moduleId)
    {
        try {
            $module = Module::findOrFail($moduleId);

            $validatedData = $request->validate([
                'module_name' => 'required|string|max:255',
                'code' => 'required|string|unique:modules,code,' . $module->id
            ]);

            $module->update($validatedData);

            return response()->json(['message' => 'Module updated successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Module not found',
                'message' => "No module found with id {$moduleId}"
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => 'An error occurred while updating the module. Please try again.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists'
            ], 500);
        }
    }

    public function delete(Request $request, Module $module)
    {
        $module->delete();

        return response()->json(['message' => 'Module deleted successfully.']);
    }
}
