<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Department;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.analytics', [
            'total' => Feedback::count(),
            'pending' => Feedback::where('status', 'Pending')->count(),
            'resolved' => Feedback::where('status', 'Resolved')->count(),
            'categories' => Feedback::select('category')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('category')
                ->get()
        ]);
    }
}
