<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $departmentId = $user->department_id;

        // Department statistics
        $totalFeedback = Feedback::where('department_id', $departmentId)->count();
        $resolvedFeedback = Feedback::where('department_id', $departmentId)
            ->where('status', 'resolved')
            ->count();
        $resolutionRate = $totalFeedback > 0 ? ($resolvedFeedback / $totalFeedback) * 100 : 0;

        // Feedback by category for this department
        $categoryStats = DB::table('feedback')
            ->join('categories', 'feedback.category_id', '=', 'categories.id')
            ->where('feedback.department_id', $departmentId)
            ->select(
                'categories.name',
                DB::raw('COUNT(feedback.id) as total'),
                DB::raw('SUM(CASE WHEN feedback.status = "resolved" THEN 1 ELSE 0 END) as resolved')
            )
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Monthly trends for this department
        $monthlyTrends = Feedback::where('department_id', $departmentId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('department.reports.index', compact(
            'totalFeedback',
            'resolvedFeedback',
            'resolutionRate',
            'categoryStats',
            'monthlyTrends'
        ));
    }
}