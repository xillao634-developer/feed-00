<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $departmentId = $user->department_id;

        $totalAssigned = Feedback::where('department_id', $departmentId)->count();
        $pendingAssigned = Feedback::where('department_id', $departmentId)
            ->where('status', 'pending')
            ->count();
        $inProgressAssigned = Feedback::where('department_id', $departmentId)
            ->where('status', 'in_progress')
            ->count();
        $resolvedAssigned = Feedback::where('department_id', $departmentId)
            ->where('status', 'resolved')
            ->count();

        // Recent assigned feedback
        $recentFeedback = Feedback::with(['user', 'category'])
            ->where('department_id', $departmentId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('department.dashboard', compact(
            'totalAssigned',
            'pendingAssigned',
            'inProgressAssigned',
            'resolvedAssigned',
            'recentFeedback'
        ));
    }
}