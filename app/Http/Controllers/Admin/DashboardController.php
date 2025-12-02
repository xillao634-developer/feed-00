<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFeedback = Feedback::count();
        $pendingFeedback = Feedback::where('status', 'pending')->count();
        $inProgressFeedback = Feedback::where('status', 'in_progress')->count();
        $resolvedFeedback = Feedback::where('status', 'resolved')->count();
        $totalUsers = User::where('role', 'user')->count();

        // Feedback by category
        $feedbackByCategory = Category::withCount('feedback')->get();

        // Recent feedback
        $recentFeedback = Feedback::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Monthly feedback trends
        $monthlyTrends = Feedback::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->get();

        return view('admin.dashboard', compact(
            'totalFeedback',
            'pendingFeedback',
            'inProgressFeedback',
            'resolvedFeedback',
            'totalUsers',
            'feedbackByCategory',
            'recentFeedback',
            'monthlyTrends'
        ));
    }
}