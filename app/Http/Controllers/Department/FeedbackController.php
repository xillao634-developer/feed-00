<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $departmentId = $user->department_id;

        $query = Feedback::with(['user', 'category', 'assignedTo'])
            ->where('department_id', $departmentId);

        // Filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $feedback = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('department.feedback.index', compact('feedback'));
    }

    public function show(Feedback $feedback)
    {
        // Ensure the feedback belongs to the department head's department
        if ($feedback->department_id !== Auth::user()->department_id) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->load(['user', 'category', 'assignedTo', 'comments.user']);

        return view('department.feedback.show', compact('feedback'));
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        // Ensure the feedback belongs to the department head's department
        if ($feedback->department_id !== Auth::user()->department_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $feedback->update(['status' => $request->status]);

        // TODO: Send notification to user about status update

        return redirect()->back()->with('success', 'Feedback status updated successfully.');
    }

    public function addComment(Request $request, Feedback $feedback)
    {
        // Ensure the feedback belongs to the department head's department
        if ($feedback->department_id !== Auth::user()->department_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $feedback->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_internal' => $request->boolean('is_internal', false)
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}