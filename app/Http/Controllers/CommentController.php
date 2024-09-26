<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Comment;
use App\Models\Submission;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getSubmissionComments(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        $comments = $submission->comments()->get();

        return response()->json(['comments' => $comments]);
    }

    /**
     * Get the specified comment
     */
    public function read(Request $request, Comment $comment)
    {
        $comment = $this->getFullComment($comment);

        return response()->json(['comment' => $comment]);
    }

    private function getFullComment(Comment $comment)
    {
        return $comment->load('assignment', 'user', 'submission');
    }

    /**
     * Store a newly created comment
     */
    public function create(Request $request, Module $module, Assignment $assignment, Submission $submission)
    {
        $validatedData = $request->validate([
            'comment_text' => 'required|string',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'assignment_id' => $assignment->id,
            'module_id' => $module->id,
            'submission_id' => $submission->id,
            'comment_text' => $validatedData['comment_text'],
        ]);

        return response()->json(['comment' => $comment, 'message' => 'Comment added successfully.']);
    }

    /**
     * Update the specified comment
     */
    public function update(Request $request, Module $module, Assignment $assignment, Submission $submission, Comment $comment)
    {
        $validatedData = $request->validate([
            'comment_text' => 'required|string',
        ]);

        $comment->update($validatedData);

        return response()->json(['comment' => $comment, 'message' => 'Comment updated successfully.']);
    }

    /**
     * Delete the specified comment
     */
    public function delete(Request $request, Module $module, Assignment $assignment, Submission $submission, Comment $comment)
    {
        $comment->delete();

        return response()->json(['comment' => $comment, 'message' => 'Comment deleted successfully.']);
    }
}
