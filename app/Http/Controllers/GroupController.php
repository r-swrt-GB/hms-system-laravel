<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Module;
use http\Client\Curl\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use PhpParser\Node\Expr\AssignOp\Mod;

class GroupController extends Controller
{

    /**
     * Store a newly created group.
     * @param Request $request
     * @param Assignment $assignment
     * @return JsonResponse
     */
    public function create(Request $request, Module $module, Assignment $assignment)
    {
        $validatedData = $request->validate([
            'name' => 'string|required',
            'user_ids' => 'array|required',
        ]);

        $group = Group::create([
            'name' => $validatedData['name'],
            'assignment_id' => $assignment->id,
        ]);

        $group->users()->attach($validatedData['user_ids']);

        return response()->json(['group' => $group, 'message' => 'Group created successfully.']);
    }

    /**
     * Display the specified group
     * @param Group $group
     * @return mixed
     */
    public function read(Module $module, Assignment $assignment, Group $group)
    {
        $group = $this->loadGroupFully($group);

        return response()->json(['group' => $group]);
    }

    private function loadGroupFully(Group $group)
    {
        return $group->load(['users', 'assignment']);
    }

    public function getUserGroups(Request $request)
    {
        $user = Auth::user();
        $groups = $user->groups()->get();
        return response()->json(['groups' => $groups]);
    }

    /**
     * Update the specified group in storage
     * @param Request $request
     * @param Group $group
     * @return mixed
     */
    public function update(Request $request, Module $module, Assignment $assignment, Group $group)
    {
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
    }

    /**
     * Remove the specified group from storage
     * @param Group $group
     * @return mixed
     */
    public function delete(Module $module, Assignment $assignment, Group $group)
    {
        $group->users()->detach();
        $group->delete();

        return response()->json(['message' => 'Group deleted successfully.']);
    }
}
