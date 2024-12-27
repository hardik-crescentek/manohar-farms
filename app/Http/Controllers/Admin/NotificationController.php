<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $notifications = Notification::where('user_id', $userId)->where('status',0)->orderBy('id', 'desc')->get();
        $data['notifications'] = $notifications;

        return view('notifications.index', $data);
    }

    public function update(Request $request, $id)
    {
       // Find the Notification instance by its ID
        $notification = Notification::findOrFail($id);

        // Update the status
        $notification->update(['status' => 1]);

        // Check if the update was successful
        if($notification) {
            return response()->json(['success' => true, 'message' => 'Notification status updated successfully!']);
        } else {
            return response()->json(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

}
