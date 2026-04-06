<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Get all notifications of logged-in user
     */
    public function getAll()
    {
        return Auth::user()->notifications;
    }

    /**
     * Get unread notifications
     */
    public function getUnread()
    {
        return Auth::user()->unreadNotifications;
    }

    /**
     * Get read notifications
     */
    public function getRead()
    {
        return Auth::user()->readNotifications;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return $notification;
    }

    /**
     * Get single notification details
     */
    public function getById($id)
    {
        return DatabaseNotification::find($id);
    }

    public function getUserNotifications()
    {
        return Notification::where('send_to', Auth::id())
            ->latest()
            ->get();
    }
}