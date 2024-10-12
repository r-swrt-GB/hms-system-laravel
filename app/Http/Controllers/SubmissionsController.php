<?php

namespace App\Http\Controllers;

use App\Http\Classes\FileUploads\FileUploadService;
use App\Models\Assignment;
use App\Models\File;
use App\Models\Group;
use App\Models\Module;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Monolog\Handler\SyslogUdpHandler;
use PhpParser\Node\Expr\AssignOp\Mod;

class SubmissionsController extends Controller
{
    public function index(Request $request, Module $module, Assignment $assignment)
    {
        $submissions = $assignment->submissions()->with('users')->get();

        return Inertia::render('Submissions/SubmissionsPage', [
            'module' => $module,
            'assignment' => $assignment,
            'submissions' => $submissions,
        ]);
    }

    public function getSubmissionPage(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        try {
            $submission = $submission->load(['users', 'comments', 'files']);
            return Inertia::render('Submissions/SubmissionPage', [
                'module' => $module,
                'assignment' => $assignment,
                'submission' => $submission,
            ]);
        } catch (\Exception $e) {
            return Inertia::render('Error', ['message' => 'An error occurred while fetching the submission.']);
        }
    }

    public function read(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        try {
            $submission = $this->getFullSubmission($submission);
            return response()->json(['submission' => $submission]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the submission.'], 500);
        }
    }

    public function getAssignmentSubmissions(Request $request, Assignment $assignment)
    {
        try {
            $submissions = $assignment->submissions();
            return response()->json(['submissions' => $submissions]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching submissions.'], 500);
        }
    }

    public function downloadFile(File $file, FileUploadService $fileUploadService)
    {
        try {
            return $fileUploadService->downloadFile($file);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while downloading the file.'], 500);
        }
    }

    public function create(Request $request, Module $module, Assignment $assignment)
    {
        try {
            $validatedData = $request->validate([
                'submission_date' => 'required|date',
                'files' => 'required|array',
            ]);

            $submission = new Submission();
            $submission->submission_date = Carbon::parse($validatedData['submission_date']);
            $submission->assignment_id = $assignment->id;
            $submission->save();

            if ($assignment->isIndividual()) {
                $userId = auth()->id();
                $submission->user()->attach($userId);
            } elseif ($assignment->isGroup()) {
                $groupId = $request->input('group_id');
                $group = Group::findOrFail($groupId);
                $groupUsers = $group->users;

                foreach ($groupUsers as $userId) {
                    $submission->user()->attach($userId);
                }
            }

            $fileUploadService = new FileUploadService();
            foreach ($request->file('files') as $file) {
                $fileUploadService->uploadFile($file, 'submissions', $submission->id);
            }

            return response()->json(['submission' => $submission, 'message' => 'Submission created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the submission.'], 500);
        }
    }

    public function update(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        try {
            $validatedData = $request->validate([
                'submission_date' => 'required|date',
                'files' => 'required|array',
            ]);

            $submission->update($validatedData);

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

            if ($request->hasFile('files')) {
                $fileUploadService = new FileUploadService();
                foreach ($request->file('files') as $file) {
                    $fileUploadService->uploadFile($file, 'submissions', $submission->id);
                }
            }

            return response()->json(['message' => 'Submission updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the submission.'], 500);
        }
    }

    public function delete(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        try {
            $submission->users()->detach();

            foreach ($submission->files as $file) {
                Storage::disk($file->disk)->delete($file->key);
                $file->delete();
            }

            $submission->delete();

            return response()->json(['message' => 'Submission deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the submission.'], 500);
        }
    }

    private function getFullSubmission(Submission $submission)
    {
        return $submission->load(['users', 'comments', 'assignments', 'files']);
    }
}
