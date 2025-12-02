<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Department\DashboardController as DepartmentDashboardController;
use App\Http\Controllers\Department\FeedbackController as DepartmentFeedbackController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\FeedbackController as UserFeedbackController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

// Authentication Routes (handled by Laravel Breeze)
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // User Routes
    Route::prefix('user')->name('user.')->middleware(['role:user'])->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/feedback', UserFeedbackController::class);
        Route::get('/my-feedback', [UserFeedbackController::class, 'myFeedback'])->name('feedback.my');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Department Head Routes
    Route::prefix('department')->name('department.')->middleware(['role:department_head'])->group(function () {
        Route::get('/dashboard', [DepartmentDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/feedback', DepartmentFeedbackController::class);
        Route::get('/reports', [DepartmentFeedbackController::class, 'reports'])->name('reports');
        Route::post('/feedback/{feedback}/assign', [DepartmentFeedbackController::class, 'assign'])->name('feedback.assign');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/feedback', AdminFeedbackController::class);
        Route::resource('/users', UserManagementController::class);
        Route::resource('/categories', CategoryController::class);
        Route::get('/reports/analytics', [ReportController::class, 'analytics'])->name('reports.analytics');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    });

    // Notifications (all roles)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

require __DIR__.'/auth.php';