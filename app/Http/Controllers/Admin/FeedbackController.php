<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Category;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with(['user', 'category', 'department', 'assignedTo']);

        // Filters
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $feedback = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::all();
        $departments = Department::all();
        $staff = User::whereIn('role', ['department_head', 'admin'])->get();

        return view('admin.feedback.index', compact('feedback', 'categories', 'departments', 'staff'));
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['user', 'category', 'department', 'assignedTo', 'comments.user']);
        $departments = Department::all();
        $staff = User::whereIn('role', ['department_head', 'admin'])->get();

        return view('admin.feedback.show', compact('feedback', 'departments', 'staff'));
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $feedback->update(['status' => $request->status]);

        // TODO: Send notification to user about status update

        return redirect()->back()->with('success', 'Feedback status updated successfully.');
    }

    public function assign(Request $request, Feedback $feedback)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'department_id' => 'nullable|exists:departments,id'
        ]);

        $feedback->update([
            'assigned_to' => $request->assigned_to,
            'department_id' => $request->department_id
        ]);

        // TODO: Send notification to assigned staff

        return redirect()->back()->with('success', 'Feedback assigned successfully.');
    }

    public function addComment(Request $request, Feedback $feedback)
    {
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

    public function destroy(Feedback $feedback)
    {
        // Delete associated files
        if ($feedback->attachment) {
            Storage::delete($feedback->attachment);
        }

        $feedback->delete();

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback deleted successfully.');
    }
}