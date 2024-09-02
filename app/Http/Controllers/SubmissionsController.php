<?php

namespace App\Http\Controllers;

use App\Http\Classes\FileUploads\FileUploadService;
use App\Models\Assignment;
use App\Models\File;
use App\Models\Group;
use App\Models\Module;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SubmissionsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Submissions/Submissions');
    }

    /**
     * Display the specified submission page.
     */
    public function getSubmissionPage(Request $request, Submission $submission)
    {
        $submission = $this->getFullSubmission($submission);

        return Inertia::render('Submissions/SubmissionPage', [
            'submission' => $submission
        ]);
    }

    /**
     * Get the specified submission.
     */
    public function read(Request $request, Submission $submission)
    {
        $submission = $this->getFullSubmission($submission);

        return response()->json(['submission' => $submission]);
    }

    public function getAssignmentSubmissions(Request $request, Assignment $assignment)
    {
        $submissions = $assignment->submissions();
        return response()->json(['submissions' => $submissions]);

    }

    public function downloadFile(File $file, FileUploadService $fileUploadService)
    {
        return $fileUploadService->downloadFile($file);
    }

    private function getFullSubmission(Submission $submission)
    {
        return $submission->load(['user', 'comments', 'assignments', 'files']);
    }

    /**
     * Store a newly created submission.
     */
    public function create(Request $request, Module $module, Assignment $assignment)
    {
        $validatedData = $request->validate([
            'submission_date' => 'required|date',
            'files' => 'required|array',
        ]);

        $submission = Submission::create($validatedData);

        if ($assignment->isIndividual()) {
            $userId = auth()->id();
            $submission->user()->attach($userId);
        } elseif ($assignment->isGroup()) {
            $groupId = $request->input('group_id');
            $group = Group::findOrFail($groupId);
            $groupUsers = $group->users;

            // Create user_submissions entries for each user in the group
            foreach ($groupUsers as $userId) {
                $submission->user()->attach($userId);
            }
        }

        $fileUploadService = new FileUploadService();
        foreach ($request->file('files') as $file) {
            $fileUploadService->uploadFile($file, 'submissions', $submission->id);
        }

        return response()->json(['submission' => $submission, 'message' => 'Submission created successfully.']);
    }

    /**
     * Update the specified submission.
     */
    public function update(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        $validatedData = $request->validate([
            'submission_date' => 'required|date',
            'files' => 'required|array',
        ]);

        $submission->update($validatedData);

        // Detach existing relationships
        $submission->user()->detach();

        if ($assignment->isIndividual()) {
            $userId = auth()->id();
            $submission->user()->attach($userId);
        } elseif ($assignment->isGroup()) {
            $groupId = $request->input('group_id');
            $group = Group::findOrFail($groupId);
            $groupUsers = $group->users;

            foreach ($groupUsers as $user) {
                $submission->user()->attach($user->id);
            }
        }

        // Handle file uploads using Azure Blob Storage
        if ($request->hasFile('files')) {
            $fileUploadService = new FileUploadService();
            foreach ($request->file('files') as $file) {
                $fileUploadService->uploadFile($file, 'submissions', $submission->id);
            }
        }

        return response()->json(['message' => 'Submission updated successfully.']);
    }

    /**
     * Remove the specified submission.
     */
    public function delete(Request $request, Module $module, Submission $submission)
    {
        // Detach all associated users
        $submission->user()->detach();

        foreach ($submission->files as $file) {
            Storage::disk($file->disk)->delete($file->key);
            $file->delete();
        }

        // Delete the submission
        $submission->delete();

        return response()->json(['message' => 'Submission deleted successfully.']);
    }
}
