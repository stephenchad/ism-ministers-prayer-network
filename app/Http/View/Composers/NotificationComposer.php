<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Collection;
use App\Models\User;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Fetch unread notifications for the authenticated user
        $notifications = collect();

        if (auth()->check()) {
            $notifications = DatabaseNotification::where('notifiable_id', auth()->id())
                ->where('notifiable_type', User::class)
                ->whereNull('read_at')
                ->paginate(10);

            $unreadCount = $notifications->total();
        } else {
            $unreadCount = 0;
        }

        $view->with('notifications', $notifications);
        $view->with('unreadCount', $unreadCount);
    }
}
