<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    public function getUserNotifications(Request $request)
    {
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->get();

            return response()->json(['notifications' => $notifications]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    public function create(Request $request, Module $module)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'message' => 'required|string',
            ]);

            $validatedData['user_id'] = Auth::user()->id;
            $validatedData['module_id'] = $module->id;

            $notification = Notification::create($validatedData);

            return response()->json(['notification' => $notification, 'message' => 'Notification created successfully.']);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    public function update(Request $request, Module $module, Notification $notification)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'message' => 'required|string',
            ]);

            $notification->update($validatedData);

            // Update association with module and user
            $notification->user_id = Auth::user()->id;
            $notification->module_id = $module->id;
            $notification->save();

            return response()->json(['message' => 'Notification updated successfully.']);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->validator->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Notification not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    public function delete(Request $request, Module $module, Notification $notification)
    {
        try {
            $notification->delete();

            return response()->json(['message' => 'Notification deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Notification not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    public function read(Request $request, Module $module, Notification $notification)
    {
        try {
            $notification = $this->getFullNotification($notification);

            return response()->json(['notification' => $notification]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Notification not found',
                'message' => "Could not find a notification with this ID."
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists'
            ], 500);
        }
    }

    public function getFullNotification(Notification $notification)
    {
        return $notification->load(['user', 'module']);
    }

    public function markAsRead(Module $module, Notification $notification, User $user)
    {
        try {
            $notification->read_at = now();
            $notification->save();

            return response()->json(['message' => 'Notification marked as read.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Notification not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $notifications = Notification::all();
            return response()->json(['notifications' => $notifications]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => 'Please try again later or contact support if the problem persists.'
            ], 500);
        }
    }
}

