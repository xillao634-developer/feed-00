@extends('layouts.user')

@section('title', 'User Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('user.feedback.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Submit Feedback
            </a>
        </div>
        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
            <i class="fas fa-print me-2"></i> Print
        </button>
    </div>
</div>

<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title">
                            <i class="fas fa-hand-wave me-2"></i>
                            Welcome back, {{ Auth::user()->name }}!
                        </h4>
                        <p class="card-text mb-0">
                            You have submitted <strong>{{ $totalFeedback }}</strong> feedback items. 
                            @if($pendingFeedback > 0)
                                <strong>{{ $pendingFeedback }}</strong> are awaiting review.
                            @endif
                        </p>
                        @if($resolvedFeedback > 0)
                            <div class="mt-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{ $resolvedFeedback }} issues resolved
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="avatar-circle bg-white text-primary mx-auto" 
                             style="width: 80px; height: 80px; font-size: 2.5rem;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start-primary border-top-0 border-end-0 border-bottom-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Total Feedback</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalFeedback }}</div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class="fas fa-chart-line me-1"></i>
                                <span>All submissions</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start-warning border-top-0 border-end-0 border-bottom-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Pending</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $pendingFeedback }}</div>
                        <div class="mt-2">
                            <span class="text-warning">
                                <i class="fas fa-clock me-1"></i>
                                <span>Awaiting review</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start-info border-top-0 border-end-0 border-bottom-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            In Progress</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $inProgressFeedback }}</div>
                        <div class="mt-2">
                            <span class="text-info">
                                <i class="fas fa-spinner me-1"></i>
                                <span>Under review</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-start-success border-top-0 border-end-0 border-bottom-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Resolved</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $resolvedFeedback }}</div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class="fas fa-check-circle me-1"></i>
                                <span>Issues fixed</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Feedback -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold text-primary">Recent Feedback</h6>
                <a href="{{ route('user.feedback.index') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recentFeedback->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5>No Feedback Submitted</h5>
                        <p class="text-muted">You haven't submitted any feedback yet.</p>
                        <a href="{{ route('user.feedback.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Submit Your First Feedback
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentFeedback as $feedback)
                                    <tr>
                                        <td><code>{{ $feedback->reference_code }}</code></td>
                                        <td>{{ Str::limit($feedback->title, 30) }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $feedback->category->name }}
                                            </span>
                                        </td>
                                        <td>@include('components.status-badge', ['status' => $feedback->status])</td>
                                        <td>{{ $feedback->created_at->format('M d') }}</td>
                                        <td>
                                            <a href="{{ route('user.feedback.show', $feedback) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Feedback Trends Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Feedback Trends (Last 30 Days)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="feedbackTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-xl-4 col-lg-5">
        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('user.feedback.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle me-2"></i> Submit New Feedback
                    </a>
                    <a href="{{ route('user.feedback.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i> View All Feedback
                    </a>
                    <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-user-edit me-2"></i> Update Profile
                    </a>
                    <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#helpModal">
                        <i class="fas fa-question-circle me-2"></i> Get Help
                    </button>
                </div>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Status Distribution</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <canvas id="statusPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="me-3">
                        <i class="fas fa-circle text-warning"></i> Pending
                    </span>
                    <span class="me-3">
                        <i class="fas fa-circle text-info"></i> In Progress
                    </span>
                    <span>
                        <i class="fas fa-circle text-success"></i> Resolved
                    </span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Recent Activity</h6>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    @php
                        $activities = [
                            ['icon' => 'fa-comment', 'color' => 'primary', 
                             'text' => 'You submitted new feedback', 'time' => '2 hours ago'],
                            ['icon' => 'fa-check-circle', 'color' => 'success', 
                             'text' => 'Your feedback was resolved', 'time' => '1 day ago'],
                            ['icon' => 'fa-spinner', 'color' => 'info', 
                             'text' => 'Feedback status updated to In Progress', 'time' => '2 days ago'],
                            ['icon' => 'fa-user-edit', 'color' => 'secondary', 
                             'text' => 'You updated your profile', 'time' => '3 days ago'],
                        ];
                    @endphp
                    
                    @foreach($activities as $activity)
                        <div class="activity-item d-flex mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-circle-sm bg-{{ $activity['color'] }} text-white">
                                    <i class="fas {{ $activity['icon'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ $activity['text'] }}</p>
                                <small class="text-muted">{{ $activity['time'] }}</small>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($recentFeedback->isNotEmpty())
                        @foreach($recentFeedback->take(2) as $feedback)
                            <div class="activity-item d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="avatar-circle-sm bg-primary text-white">
                                        <i class="fas fa-comment"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1">You submitted: {{ Str::limit($feedback->title, 40) }}</p>
                                    <small class="text-muted">{{ $feedback->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-sm btn-outline-primary">View Full Activity Log</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Announcements -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow border-left-info">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="m-0 fw-bold text-info">
                    <i class="fas fa-bullhorn me-2"></i>System Announcements
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle fa-2x text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>New Feature: Anonymous Feedback</h6>
                                <p class="mb-0 small text-muted">You can now submit feedback anonymously.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Response Time Update</h6>
                                <p class="mb-0 small text-muted">Average response time is now 24-48 hours.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-mobile-alt fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Mobile App Coming Soon</h6>
                                <p class="mb-0 small text-muted">Access feedback portal from your mobile device.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">
                    <i class="fas fa-question-circle me-2"></i>Help & Support
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <i class="fas fa-video fa-3x text-primary mb-3"></i>
                                <h5>Video Tutorials</h5>
                                <p class="text-muted">Watch step-by-step guides</p>
                                <button class="btn btn-outline-primary w-100">View Tutorials</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                                <h5>Documentation</h5>
                                <p class="text-muted">Read user guides & FAQs</p>
                                <button class="btn btn-outline-success w-100">Open Docs</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6>Need Immediate Help?</h6>
                    <div class="list-group">
                        <a href="mailto:support@feedbackportal.com" class="list-group-item list-group-item-action">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            Email Support: support@feedbackportal.com
                        </a>
                        <a href="tel:+1234567890" class="list-group-item list-group-item-action">
                            <i class="fas fa-phone text-success me-2"></i>
                            Call Support: +1 (234) 567-890
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-comments text-info me-2"></i>
                            Live Chat (Available 9AM-5PM)
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    
    .border-start-primary { border-left-color: #4e73df !important; }
    .border-start-warning { border-left-color: #f6c23e !important; }
    .border-start-info { border-left-color: #36b9cc !important; }
    .border-start-success { border-left-color: #1cc88a !important; }
    
    .avatar-circle-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .activity-item {
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .chart-area, .chart-pie {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Feedback Trend Chart
    const trendCtx = document.getElementById('feedbackTrendChart').getContext('2d');
    const trendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
            datasets: [{
                label: 'Feedback Submitted',
                data: [2, 3, 1, 4, 2, 3, 2],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#4e73df',
                pointRadius: 3,
                pointHoverRadius: 5,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Status Pie Chart
    const pieCtx = document.getElementById('statusPieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Resolved'],
            datasets: [{
                data: [
                    {{ $pendingFeedback }},
                    {{ $inProgressFeedback }},
                    {{ $resolvedFeedback }}
                ],
                backgroundColor: [
                    '#f6c23e',
                    '#36b9cc',
                    '#1cc88a'
                ],
                hoverBackgroundColor: [
                    '#f6c23e',
                    '#36b9cc',
                    '#1cc88a'
                ],
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Statistics Cards Click Events
    document.querySelectorAll('.stat-card').forEach((card, index) => {
        card.addEventListener('click', function() {
            let status = '';
            switch(index) {
                case 0: status = ''; break; // All
                case 1: status = 'pending'; break;
                case 2: status = 'in_progress'; break;
                case 3: status = 'resolved'; break;
            }
            
            if (status) {
                window.location.href = `{{ route('user.feedback.index') }}?status=${status}`;
            } else {
                window.location.href = `{{ route('user.feedback.index') }}`;
            }
        });
    });

    // Auto-refresh dashboard every 5 minutes
    setTimeout(() => {
        window.location.reload();
    }, 300000); // 5 minutes

    // Print Dashboard
    function printDashboard() {
        const printContent = document.querySelector('.main-content').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Dashboard Report - {{ Auth::user()->name }}</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .print-header { text-align: center; margin-bottom: 30px; }
                    .stat-card { border: 1px solid #ddd; padding: 15px; margin: 10px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    .print-footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h2>Dashboard Report</h2>
                    <p>Generated on: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}</p>
                    <p>User: {{ Auth::user()->name }}</p>
                </div>
                ${printContent}
                <div class="print-footer">
                    <p>Smart Feedback Portal - Generated Report</p>
                </div>
            </body>
            </html>
        `;
        
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
    }

    // Add print functionality to print button
    document.querySelector('button[onclick="window.print()"]').addEventListener('click', function(e) {
        e.preventDefault();
        printDashboard();
    });

    // Real-time notification check
    function checkNotifications() {
        // This would typically make an API call
        console.log('Checking for new notifications...');
    }

    // Check for notifications every minute
    setInterval(checkNotifications, 60000);
</script>
@endpush
@endsection