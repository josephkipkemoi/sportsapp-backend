<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewRegisteredUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class RegisteredUserNotificationController extends Controller
{
    //
    public function index(Request $request, User $user)
    {
         return $user->find($request->query('u_id'))->unreadNotifications;
    }

    public function markRead(Request $request, User $user)
    {
        return $user->find($request->query('u_id'))->unreadNotifications->markAsRead();
    }

    public function all(Request $request, User $user)
    {
        return $user->find($request->query('u_id'))->notifications;
    }

}
