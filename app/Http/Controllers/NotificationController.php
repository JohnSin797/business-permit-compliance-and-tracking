<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    public function show($id)
    {
        $notifications = Notification::where('user_id', $id)->orderByDesc('created_at')->get();
        return response()->json([
            'message' => 'OK',
            'notifications' => $notifications
        ], 200);
    }

    public function delete($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    public function update($id)
    {
        $user = User::findOrFail($id);
        Notification::where('user_id', $id)->update([
            'status' => 'read'
        ]);

        $notifications = Notification::where('user_id', $id)->orderByDesc('created_at')->get();
        return response()->json([
            'message' => 'OK',
            'notifications' => $notifications
        ], 200);
    }
}
