<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUserNotifications(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()->get();

        return response()->json(['notifications' => $notifications]);
    }

    public function create(Request $request, Module $module)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['module_id'] = $module->id;

        $notification = Notification::create($validatedData);

        return response()->json(['notification' => $notification, 'message' => 'Notification created successfully.']);
    }

    public function update(Request $request, Module $module, Notification $notification)
    {
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
    }

    public function delete(Request $request, Module $module, Notification $notification)
    {
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully.']);
    }

    public function read(Request $request, Module $module, Notification $notification)
    {
        $notification = $this->getFullNotification($notification);

        return response()->json(['notification' => $notification]);
    }

    public function getFullNotification(Notification $notification)
    {
        return $notification->load(['user', 'module']);
    }

    public function markAsRead(Module $module, Notification $notification, User $user)
    {
        $notification->read_at = now();
        $notification->save();

        return response()->json(['message' => 'Notification marked as read.']);
    }

    public function list(Request $request)
    {
        $notifications = Notification::all();
        return response()->json(['notifications' => $notifications]);
    }
}

