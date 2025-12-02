<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\FeedbackExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function analytics()
    {
        // Overall statistics
        $totalFeedback = Feedback::count();
        $pendingCount = Feedback::where('status', 'pending')->count();
        $inProgressCount = Feedback::where('status', 'in_progress')->count();
        $resolvedCount = Feedback::where('status', 'resolved')->count();

        // Feedback by category
        $categoryStats = Category::withCount(['feedback as total_feedback'])
            ->withCount(['feedback as pending_feedback' => function($query) {
                $query->where('status', 'pending');
            }])
            ->withCount(['feedback as resolved_feedback' => function($query) {
                $query->where('status', 'resolved');
            }])
            ->get();

        // Monthly trends
        $monthlyTrends = Feedback::select(
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

        // Department performance
        $departmentStats = DB::table('departments')
            ->leftJoin('feedback', 'departments.id', '=', 'feedback.department_id')
            ->select(
                'departments.name',
                DB::raw('COUNT(feedback.id) as total_assigned'),
                DB::raw('SUM(CASE WHEN feedback.status = "resolved" THEN 1 ELSE 0 END) as resolved')
            )
            ->groupBy('departments.id', 'departments.name')
            ->get();

        return view('admin.reports.analytics', compact(
            'totalFeedback',
            'pendingCount',
            'inProgressCount',
            'resolvedCount',
            'categoryStats',
            'monthlyTrends',
            'departmentStats'
        ));
    }

    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:excel,pdf',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:pending,in_progress,resolved'
        ]);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            'status' => $request->status
        ];

        if ($request->format === 'excel') {
            return Excel::download(new FeedbackExport($filters), 'feedback-report-' . date('Y-m-d') . '.xlsx');
        } else {
            $feedback = $this->getFilteredFeedback($filters);
            $pdf = PDF::loadView('admin.reports.pdf.feedback', compact('feedback', 'filters'));
            return $pdf->download('feedback-report-' . date('Y-m-d') . '.pdf');
        }
    }

    private function getFilteredFeedback($filters)
    {
        $query = Feedback::with(['user', 'category', 'department', 'assignedTo']);

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}