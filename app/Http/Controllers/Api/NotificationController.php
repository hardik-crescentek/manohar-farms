<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function notifications() {
        try {
            $userId = Auth::user()->id;
            $notifications = Notification::where('user_id', $userId)->get();
    
            // Check if the collection is not empty
            if (!$notifications->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'notifications' => $notifications
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No notifications found for the current user.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching notifications.',
                'error' => $e->getMessage() // Include the error message for debugging
            ], 500);
        }
    }
}
