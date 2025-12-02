<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id = null)
    {
        if ($id) {
            $notification = Auth::user()->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        } else {
            Auth::user()->unreadNotifications->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        Auth::user()->notifications()->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }

    public function clearAll()
    {
        Auth::user()->notifications()->delete();

        return redirect()->back()->with('success', 'All notifications cleared.');
    }
}