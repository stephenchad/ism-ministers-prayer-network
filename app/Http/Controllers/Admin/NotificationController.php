<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = DatabaseNotification::query()->with('notifiable')
            ->orderBy('created_at', 'desc');

        // Filter by type if specified
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->whereNotNull('read_at');
            } elseif ($request->status === 'unread') {
                $query->whereNull('read_at');
            }
        }

        // Filter by user if specified
        if ($request->filled('user_id')) {
            $query->where('notifiable_type', 'App\Models\User')
                  ->where('notifiable_id', $request->user_id);
        }

        $notifications = $query->paginate(20);

        // Get notification types for filter dropdown
        $notificationTypes = collect([
            ['value' => 'App\Notifications\AdminAddedNewEvent', 'label' => 'AdminAddedNewEvent'],
            ['value' => 'App\Notifications\BirthdayNotification', 'label' => 'BirthdayNotification'],
            ['value' => 'App\Notifications\BulkMessageSent', 'label' => 'BulkMessageSent'],
            ['value' => 'App\Notifications\BulkUploadCompleted', 'label' => 'BulkUploadCompleted'],
            ['value' => 'App\Notifications\GroupLeaderPromotedToCoordinator', 'label' => 'GroupLeaderPromotedToCoordinator'],
            ['value' => 'App\Notifications\NewGroupCreated', 'label' => 'NewGroupCreated'],
            ['value' => 'App\Notifications\NewPrayerResourceAdded', 'label' => 'NewPrayerResourceAdded'],
            ['value' => 'App\Notifications\NewRadioAdded', 'label' => 'NewRadioAdded'],
            ['value' => 'App\Notifications\NewReferralNotification', 'label' => 'NewReferralNotification'],
            ['value' => 'App\Notifications\NewStreamAdded', 'label' => 'NewStreamAdded'],
            ['value' => 'App\Notifications\PromotedToCoordinator', 'label' => 'PromotedToCoordinator'],
            ['value' => 'App\Notifications\PromotedToGroupLeader', 'label' => 'PromotedToGroupLeader'],
            ['value' => 'App\Notifications\RemovedFromGroup', 'label' => 'RemovedFromGroup'],
            ['value' => 'App\Notifications\SocialMediaActivityNotification', 'label' => 'SocialMediaActivityNotification'],
            ['value' => 'App\Notifications\UserCreatedNewGroup', 'label' => 'UserCreatedNewGroup'],
        ]);

        // Get stats
        $stats = [
            'total' => DatabaseNotification::count(),
            'unread' => DatabaseNotification::whereNull('read_at')->count(),
            'read' => DatabaseNotification::whereNotNull('read_at')->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'notificationTypes', 'stats'));
    }

    public function show($id)
    {
        $notification = DatabaseNotification::with('notifiable')->findOrFail($id);

        return view('admin.notifications.show', compact('notification'));
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAsUnread($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        $notification->read_at = null;
        $notification->save();

        return redirect()->back()->with('success', 'Notification marked as unread.');
    }

    public function markMultipleAsRead(Request $request)
    {
        $ids = $request->input('notification_ids', []);
        if (!empty($ids)) {
            DatabaseNotification::whereIn('id', $ids)->update(['read_at' => now()]);
        }

        return redirect()->back()->with('success', 'Selected notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully.');
    }

    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('notification_ids', []);
        if (!empty($ids)) {
            DatabaseNotification::whereIn('id', $ids)->delete();
        }

        return redirect()->back()->with('success', 'Selected notifications deleted successfully.');
    }

    public function clearAll()
    {
        DatabaseNotification::truncate();

        return redirect()->back()->with('success', 'All notifications cleared successfully.');
    }
}
