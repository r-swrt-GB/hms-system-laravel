<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{

    /**
     * Store a newly created group.
     * @param Request $request
     * @param Module $module
     * @param Assignment $assignment
     * @return JsonResponse
     */
    public function create(Request $request, Module $module, Assignment $assignment)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'string|required',
                'user_ids' => 'array|required',
            ]);

            // Create the group
            $group = Group::create([
                'name' => $validatedData['name'],
                'assignment_id' => $assignment->id,
            ]);

            // Attach users to the group
            $group->users()->attach($validatedData['user_ids']);

            return response()->json(['group' => $group, 'message' => 'Group created successfully.'], 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->validator->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Assignment not found',
                'message' => "No assignment found with ID {$assignment->id}",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }


    /**
     * Display the specified group.
     * @param Module $module
     * @param Assignment $assignment
     * @param Group $group
     * @return JsonResponse
     */
    public function read(Module $module, Assignment $assignment, Group $group)
    {
        try {
            $group = $this->loadGroupFully($group);

            return response()->json(['group' => $group]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Group not found',
                'message' => "No group found with ID {$group->id}",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.',
            ], 500);
        }
    }

    public function list(Module $module, Assignment $assignment)
    {
        try {

            if (!$assignment->isGroup()) {
                return response()->json(['message' => 'This assignment is not a group assignment.'], 403);
            }

            $groups = $assignment->groups();

            return response()->json(['group' => $groups]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.',
            ], 500);
        }
    }


    private function loadGroupFully(Group $group)
    {
        return $group->load(['users', 'assignment']);
    }

    /**
     * Get the groups associated with the authenticated user.
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserGroups(Request $request)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            // Fetch the user's groups
            $groups = $user->groups()->get();

            return response()->json(['groups' => $groups]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.',
            ], 500);
        }
    }


    /**
     * Update the specified group in storage.
     *
     * @param Request $request
     * @param Module $module
     * @param Assignment $assignment
     * @param Group $group
     * @return mixed
     */
    public function update(Request $request, Module $module, Assignment $assignment, Group $group)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'string|required',
                'user_ids' => 'array|required',
            ]);

            $group->update([
                'name' => $validatedData['name'],
            ]);

            // Sync users to the group
            $group->users()->sync($validatedData['user_ids']);

            return response()->json(['group' => $group, 'message' => 'Group updated successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Group not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    /**
     * Remove the specified group from storage.
     *
     * @param Module $module
     * @param Assignment $assignment
     * @param Group $group
     * @return mixed
     */
    public function delete(Module $module, Assignment $assignment, Group $group)
    {
        try {
            $group->users()->detach();
            $group->delete();

            return response()->json(['message' => 'Group deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Group not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }
}
