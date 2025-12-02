<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::with(['category', 'department', 'assignedTo'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.feedback.index', compact('feedback'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.feedback.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'attachment' => 'nullable|file|max:10240', // 10MB max
            'is_anonymous' => 'boolean'
        ]);

        // Generate unique reference code
        $referenceCode = 'FB-' . strtoupper(Str::random(8)) . '-' . date('Ymd');

        $feedbackData = [
            'user_id' => $request->boolean('is_anonymous') ? null : Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'reference_code' => $referenceCode,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => 'pending'
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('feedback/attachments', $filename, 'public');
            $feedbackData['attachment'] = $path;
        }

        $feedback = Feedback::create($feedbackData);

        // TODO: Send notification to admin

        return redirect()->route('user.feedback.show', $feedback)
            ->with('success', 'Feedback submitted successfully! Your reference code: ' . $referenceCode);
    }

    public function show(Feedback $feedback)
    {
        // Ensure the feedback belongs to the user or is anonymous (created by the same user)
        if ($feedback->user_id && $feedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->load(['category', 'department', 'assignedTo', 'comments' => function($query) {
            $query->where('is_internal', false)->with('user');
        }]);

        return view('user.feedback.show', compact('feedback'));
    }

    public function addComment(Request $request, Feedback $feedback)
    {
        // Ensure the feedback belongs to the user
        if ($feedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $feedback->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_internal' => false
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}