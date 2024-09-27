<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Comment;
use App\Models\Submission;
use App\Models\Module;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Get comments for a specific submission.
     */
    public function getSubmissionComments(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        try {
            $user = Auth::user();

            // If the user is a student, check if the submission belongs to them
            if ($user->hasRole('student') && !$user->submissions()->where('id', $submission->id)->exists()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => "You can only view comments on your own submission."
                ], 403);
            }

            // Retrieve the comments for the submission
            $comments = $submission->comments()->get();

            return response()->json(['comments' => $comments]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Submission not found',
                'message' => "No submission found with ID {$submission->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }

    /**
     * Get the specified comment.
     */
    public function read(Request $request, Module $module, Assignment $assignment, Submission $submission, Comment $comment)
    {
        try {
            $user = Auth::user();

            // If the user is a student, check if the submission belongs to them
            if ($user->hasRole('student') && !$user->submissions()->where('id', $submission->id)->exists()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => "You can only view comments on your own submission."
                ], 403); // Forbidden
            }

            // Check if the comment belongs to the specified submission
            if ($comment->submission_id !== $submission->id) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => "You do not have access to this comment."
                ], 403); // Forbidden
            }

            $comment = $this->getFullComment($comment);

            return response()->json(['comment' => $comment]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Comment not found',
                'message' => "No comment found with ID {$comment->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }


    private function getFullComment(Comment $comment)
    {
        return $comment->load('assignment', 'user', 'submission');
    }

    /**
     * Store a newly created comment.
     */
    public function create(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'comment_text' => 'required|string',
            ]);

            // Create the comment
            $comment = Comment::create([
                'user_id' => Auth::id(),
                'assignment_id' => $assignment->id,
                'module_id' => $module->id,
                'submission_id' => $submission->id,
                'comment_text' => $validatedData['comment_text'],
            ]);

            return response()->json(['comment' => $comment, 'message' => 'Comment added successfully.'], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Module $module, Assignment $assignment, Submission $submission, Comment $comment)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'comment_text' => 'required|string',
            ]);

            // Update the comment
            $comment->update($validatedData);

            return response()->json(['comment' => $comment, 'message' => 'Comment updated successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Comment not found',
                'message' => "No comment found with ID {$comment->id}",
            ], 404); // Not Found
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }

    /**
     * Delete the specified comment.
     */
    public function delete(Request $request, Module $module, Assignment $assignment, Submission $submission, Comment $comment)
    {
        try {
            if (!$comment) {
                return response()->json([
                    'error' => 'Comment not found',
                    'message' => "No comment found with ID {$comment->id}",
                ], 404);
            }

            // Delete the comment
            $comment->delete();

            return response()->json(['comment' => $comment, 'message' => 'Comment deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Comment not found',
                'message' => "No comment found with id {$module->id}"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists',
            ], 500);
        }
    }

}
