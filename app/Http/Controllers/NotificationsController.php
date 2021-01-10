<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('notifications.show',[ 'notifications' => tap(auth()->user()->unreadNotifications)->markAsRead()]);
    }
}
