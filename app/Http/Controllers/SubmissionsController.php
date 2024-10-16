<?php

namespace App\Http\Controllers;

use App\Http\Classes\FileUploads\FileUploadService;
use App\Models\Assignment;
use App\Models\File;
use App\Models\Group;
use App\Models\Module;
use App\Models\Submission;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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


    public function getPresignedUrl(Request $request, Module $module, Assignment $assignment)
    {
        $fileName = $request->input('file_name');
        $contentType = $request->input('content_type');  // e.g., 'video/mp4'
        $filePath = 'videos/' . $fileName;  // Path in your S3 bucket

        // Set expiration time (e.g., 60 minutes)
        $expiration = Carbon::now()->addMinutes(60);

        // Create an S3 client instance using the AWS SDK
        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION') ?? 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID') ?? 'AKIA2UC3CETXW2VS6VXZ',
                'secret' => env('AWS_SECRET_ACCESS_KEY') ?? '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',
            ],
        ]);

        // Generate the pre-signed URL
        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => env('AWS_BUCKET') ?? 'hms-system-nwu',
            'Key' => $filePath,
            'ACL' => 'public-read',  // Set ACL if needed
            'ContentType' => $contentType,
        ]);

        // Create the pre-signed request
        $request = $s3Client->createPresignedRequest($cmd, $expiration);

        // Get the URL from the pre-signed request
        $presignedUrl = (string)$request->getUri();

        return response()->json([
            'url' => $presignedUrl,
            'filePath' => $filePath,
        ]);
    }

    public function create(Request $request, Module $module, Assignment $assignment)
    {
        try {
            $submission = new Submission();
            $submission->submission_date = Carbon::parse($request->get('submission_date'));
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
            foreach ($request->get('files') as $file) {
                $fileUploadService->saveFile($file, $submission->id);
            }

            $submission = $submission->with('files')->find($submission->id);

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
