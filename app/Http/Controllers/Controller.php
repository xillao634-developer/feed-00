<?php
use App\Models\Feedback;
use App\Models\Department;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create', 'store']);
    }


    public function index()
    {
        $q = request('q');
        $feedbacks = Feedback::when($q, fn($qb) => $qb->where('subject', 'like', '%' . request('q') . '%'))
            ->latest()->paginate(12);
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
            'category' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'file' => 'nullable|file|max:2048',
        ]);


        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads', 'public');
        }


        $code = strtoupper(Str::random(8));

        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'department_id' => $data['department_id'] ?? null,
            'category' => $data['category'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'file_path' => $path,
            'is_anonymous' => $request->has('is_anonymous'),
            'reference_code' => $code,
        ]);


        // TODO: notify admin(s)


        return redirect()->route('feedback.create')->with('success', 'Feedback submitted. Reference: ' . $code);
    }


    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }


    public function updateStatus(Request $request, Feedback $feedback)
    {
        $request->validate(['status' => 'required|in:Pending,In Progress,Resolved']);
        $feedback->update(['status' => $request->status]);


        // TODO: send notification


        return back()->with('success', 'Status updated');
    }
}