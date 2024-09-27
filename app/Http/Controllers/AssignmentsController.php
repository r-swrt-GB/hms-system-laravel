<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AssignmentsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Assignments/AssignmentsPage');
    }

    public function getModuleAssignments(Request $request, Module $module)
    {
        try {
            $assignments = $module->assignments()->get();
            return response()->json(['assignments' => $assignments]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Module not found',
                'message' => "No module found with id {$module->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }


    public function getUserAssignments(Request $request)
    {
        $user = Auth::user();

        try {
            // Retrieve the assignments for the authenticated user
            $assignments = $user->assignments()->get();

            return response()->json(['assignments' => $assignments]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Assignments not found',
                'message' => "No assignments found for user with ID {$user->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }


    public function getAssignmentPage(Request $request, Assignment $assignment)
    {
        $assignment = $this->loadFullAssignment($assignment);

        return Inertia::render('Assignments/AssignmentPage', ['assignment' => $assignment]);
    }

    public function getCreateAssignmentPage(Request $request)
    {
        return Inertia::render('Assignments/CreateAssignmentsPage');
    }

    /**
     * Store a newly created assignment.
     */
    public function create(Request $request, Module $module)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'title' => 'string|required',
                'description' => 'string|required',
                'type' => 'string|required|in:individual,group',
                'min_videos' => 'integer|required',
                'max_videos' => 'integer|required',
                'max_video_length' => 'integer|required',
                'max_grade' => 'integer|required',
                'open_date' => 'date|required',
                'due_date' => 'date|required',
                'group_ids' => 'array',
            ]);

            // Create the assignment
            $validatedData['module_id'] = $module->id;
            $validatedData['user_id'] = Auth::user()->id;
            $assignment = Assignment::create($validatedData);

            if ($assignment->isIndividual()) {
                // Attach all users of the module to the assignment
                $users = $module->users;
                $assignment->users()->attach($users->pluck('id')->toArray());
            } else if ($assignment->isGroup() && $request->has('group_ids')) {
                // Attach users of the specified groups to the assignment
                $groupIds = $validatedData['group_ids'];
                $groups = Group::whereIn('id', $groupIds)->with('users')->get();
                $userIds = $groups->pluck('users.*.id')->flatten()->unique()->toArray();
                $assignment->users()->attach($userIds);
            }

            return response()->json(['assignment' => $assignment, 'message' => 'Assignment created successfully.']);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'messages' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }


    /**
     * Update the specified assignment.
     */
    public function update(Request $request, Module $module, Assignment $assignment)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'title' => 'string|required',
                'description' => 'string|required',
                'type' => 'string|required|in:individual,group',
                'min_videos' => 'integer|required',
                'max_videos' => 'integer|required',
                'max_video_length' => 'integer|required',
                'max_grade' => 'integer|required',
                'open_date' => 'date|required',
                'due_date' => 'date|required',
                'group_ids' => 'array',
            ]);

            // Update the assignment
            $assignment->update($validatedData);

            if ($assignment->isIndividual()) {
                // Sync all users of the module to the assignment
                $users = $module->users;
                $assignment->users()->sync($users->pluck('id')->toArray());
            } else if ($assignment->isGroup() && $request->has('group_ids')) {
                // Sync users of the specified groups to the assignment
                $groupIds = $validatedData['group_ids'];
                $groups = Group::whereIn('id', $groupIds)->with('users')->get();
                $userIds = $groups->pluck('users.*.id')->flatten()->unique()->toArray();
                $assignment->users()->sync($userIds);
            }

            return response()->json(['assignment' => $assignment, 'message' => 'Assignment updated successfully.']);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'messages' => $e->validator->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Assignment not found',
                'message' => "No assignment found with ID {$assignment->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }


    /**
     * Remove the specified assignment.
     */
    public function delete(Request $request, Module $module, Assignment $assignment)
    {
        try {
            // Detach users and delete the assignment
            $assignment->users()->detach();
            $assignment->delete();

            return response()->json(['assignment' => $assignment, 'message' => 'Assignment deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Assignment not found',
                'message' => "No assignment found with ID {$assignment->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }


    /**
     * Get the specified assignment.
     */
    public function read(Request $request, Module $module, Assignment $assignment)
    {
        try {
            // Load the full assignment details
            $assignment = $this->loadFullAssignment($assignment);

            return response()->json(['assignment' => $assignment]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Assignment not found',
                'message' => "No assignment found with ID {$assignment->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }

    private function loadFullAssignment(Assignment $assignment): Assignment
    {
        return $assignment->load(['submissions', 'module']);
    }
}
