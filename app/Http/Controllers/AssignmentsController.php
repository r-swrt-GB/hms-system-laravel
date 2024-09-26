<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use PhpParser\Node\Expr\AssignOp\Mod;

class AssignmentsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Assignments/AssignmentsPage');
    }

    public function getModuleAssignments(Request $request, Module $module)
    {
        $assignments = $module->assignments()->get();
        return response()->json(['assignments' => $assignments]);
    }

    public function getUserAssignments(Request $request)
    {
        $user = Auth::user();
        $assignments = $user->assignments()->get();
        return response()->json(['assignments' => $assignments]);
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

        $validatedData['module_id'] = $module->id;
        $validatedData['user_id'] = Auth::user()->id;
        $assignment = Assignment::create($validatedData);
        $assignment->save();

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
    }

    /**
     * Update the specified assignment.
     */
    public function update(Request $request, Module $module, Assignment $assignment)
    {
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
    }

    /**
     * Remove the specified assignment.
     */
    public function delete(Request $request, Module $module, Assignment $assignment)
    {
        $assignment->users()->detach();
        $assignment->delete();

        return response()->json(['assignment' => $assignment, 'message' => 'Assignment deleted successfully.']);
    }

    /**
     * Get the specified assignment.
     */
    public function read(Request $request, Module $module, Assignment $assignment)
    {
        $assignment = $this->loadFullAssignment($assignment);

        return response()->json(['assignment' => $assignment]);
    }

    private function loadFullAssignment(Assignment $assignment): Assignment
    {
        return $assignment->load(['submissions', 'module']);
    }
}
