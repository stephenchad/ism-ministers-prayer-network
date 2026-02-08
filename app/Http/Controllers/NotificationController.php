<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
      /**
       * Mark a specific notification as read and redirect.
       */
      public function markAsRead(Request $request, $id)
      {
            $notification = Auth::user()->notifications()->where('id', $id)->first();

            if ($notification) {
                  $notification->markAsRead();
            }

            // Redirect to the URL from the notification data, or back if no URL is provided.
            $redirectUrl = $request->query('url', url()->previous());

            return redirect($redirectUrl);
      }

      /**
       * Mark all unread notifications as read.
       */
      public function markAllAsRead()
      {
            Auth::user()->unreadNotifications->markAsRead();

            return redirect()->back()->with('success', 'All notifications marked as read.');
      }
}