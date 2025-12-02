<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalFeedback = Feedback::where('user_id', $user->id)->count();
        $pendingFeedback = Feedback::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $inProgressFeedback = Feedback::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count();
        $resolvedFeedback = Feedback::where('user_id', $user->id)
            ->where('status', 'resolved')
            ->count();

        // Recent feedback
        $recentFeedback = Feedback::with(['category', 'department'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('user.dashboard', compact(
            'totalFeedback',
            'pendingFeedback',
            'inProgressFeedback',
            'resolvedFeedback',
            'recentFeedback'
        ));
    }
}