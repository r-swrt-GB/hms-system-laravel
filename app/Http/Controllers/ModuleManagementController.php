<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModuleManagementController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $modules = $user->modules()->get();

        $users = User::all();

        return Inertia::render('Management/ModuleManagementPage', ['appBarHeader' => 'Module Management', 'modules' => $modules, 'users' => $users]);
    }

    public function modifyModuleStudents(Request $request, Module $module)
    {
        $validated = $request->validate([
            'enrolledStudents' => 'required|array',
        ]);

        $enrolledStudents = $validated['enrolledStudents'];

        $enrolledStudents[] = Auth::id();

        $module->users()->sync($enrolledStudents);

        return response()->json([
            'status' => 'success',
            'message' => 'Module students have been updated successfully.',
        ]);
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

    public function read(Request $request, Module $module)
    {
        try {
            return response()->json(['module' => $module]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Module not found',
                'message' => "Could not find a module with this ID.}"
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
                'code' => 'required|string|unique:modules,code',
                'description' => 'required|string'
            ]);

            $module = Module::create($validatedData);


            $module->users()->attach(Auth::user()->id);

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

    public function update(Request $request, Module $module)
    {
        try {
            $validatedData = $request->validate([
                'module_name' => 'required|string|max:255',
                'code' => 'required|string|unique:modules,code,' . $module->id
            ]);

            $module->update($validatedData);

            return response()->json(['message' => 'Module updated successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Module not found',
                'message' => "No module found with id {$module->id}"
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

    /**
     * Remove the specified module from storage.
     *
     * @param Request $request
     * @param Module $module
     * @return mixed
     */
    public function delete(Request $request, Module $module)
    {
        try {
            $module->delete();

            return response()->json(['message' => 'Module deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Module not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }
}
