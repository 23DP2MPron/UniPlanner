<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    // Get upcoming tasks (next 7 days)
    $upcomingTasks = $user->tasks()
        ->with('subject')
        ->where('status', '!=', 'completed')
        ->where('due_date', '>=', now())
        ->where('due_date', '<=', now()->addDays(7))
        ->orderBy('due_date')
        ->orderBy('due_time')
        ->limit(5)
        ->get();

    // Get overdue tasks
    $overdueTasks = $user->tasks()
        ->with('subject')
        ->where('status', '!=', 'completed')
        ->where('due_date', '<', now())
        ->orderBy('due_date', 'desc')
        ->limit(5)
        ->get();

    // Get upcoming events (next 7 days)
    $upcomingEvents = $user->events()
        ->with('subject')
        ->where('start_date', '>=', now())
        ->where('start_date', '<=', now()->addDays(7))
        ->orderBy('start_date')
        ->orderBy('start_time')
        ->limit(5)
        ->get();

    // Get statistics
    $stats = [
        'total_subjects' => $user->subjects()->count(),
        'total_tasks' => $user->tasks()->count(),
        'completed_tasks' => $user->tasks()->where('status', 'completed')->count(),
        'pending_tasks' => $user->tasks()->where('status', 'pending')->count(),
        'in_progress_tasks' => $user->tasks()->where('status', 'in_progress')->count(),
        'total_events' => $user->events()->count(),
        'overdue_count' => $user->tasks()
            ->where('status', '!=', 'completed')
            ->where('due_date', '<', now())
            ->count(),
    ];

    return Inertia::render('Dashboard', [
        'upcomingTasks' => $upcomingTasks,
        'overdueTasks' => $overdueTasks,
        'upcomingEvents' => $upcomingEvents,
        'stats' => $stats,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Subject routes
    Route::resource('subjects', SubjectController::class);

    // Task routes
    Route::resource('tasks', TaskController::class);

    // Event routes
    Route::resource('events', EventController::class);
});

require __DIR__.'/auth.php';
