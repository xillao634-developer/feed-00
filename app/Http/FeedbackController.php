<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('feedback.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'department_id' => 'nullable|exists:departments,id',
            'file' => 'nullable|file|max:2048'
        ]);

        $path = $request->file('file')?->store('uploads', 'public');

        Feedback::create([
            'user_id' => Auth::id(),
            'department_id' => $data['department_id'] ?? null,
            'category' => $data['category'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'file_path' => $path,
            'status' => 'Pending',
            'is_anonymous' => $request->has('is_anonymous'),
            'reference_code' => strtoupper(Str::random(8))
        ]);

        return back()->with('success', 'Feedback submitted!');
    }

    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        $request->validate(['status' => 'required']);
        $feedback->update(['status' => $request->status]);

        return back()->with('success', 'Status updated');
    }
}
