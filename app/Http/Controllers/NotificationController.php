<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function create(Request $request, Module $module)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
        ]);

        $notification = Notification::create($validatedData);

        $notification -> user_id = Auth::user() -> id;
        $notification -> module_id = $module -> id;
        $notification -> save();

        return response() -> json(['message' => 'Notification created successfully.']);
    }

    public function update(Request $request, Module $module, Notification $notification)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
        ]);

        $notification -> update($validatedData);

        $notification -> user_id = Auth::user() -> id;
        $notification -> module_id = $module -> id;
        $notification -> save();

        return response() -> json(['message' => 'Notification updated successfully.']);
    }

    public function delete(Request $request, Module $module, Notification $notification)
    {
        $notification -> delete();

        return response() -> json(['message' => 'Notification deleted successfully.']);

    }

    public function read(Request $request, Module $module, Notification $notification)
    {
        $notification = $this -> getFullNotification($notification);

        return response() -> json(['notification' => $notification]);
    }

    public function getFullNotification(Notification $notification)
    {
        return $notification->load(['user', 'module', 'title', 'message','type']);
    }
    //
}
