<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Redirect dashboard to mentor dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('mentor.dashboard');
    })->name('dashboard');

    // Mentor Routes
    Route::get('/mentor/dashboard', App\Livewire\Mentor\Dashboard::class)->name('mentor.dashboard');
    Route::get('/mentor/students', App\Livewire\Mentor\Students::class)->name('mentor.students');
    Route::get('/mentor/students/{studentId}', App\Livewire\Mentor\StudentProfile::class)->name('mentor.students.profile');
    Route::get('/mentor/calendar', App\Livewire\Mentor\Calendar::class)->name('mentor.calendar');
    Route::get('/mentor/tasks', App\Livewire\Mentor\Tasks::class)->name('mentor.tasks');
    Route::get('/mentor/training', App\Livewire\Mentor\TrainingCenter::class)->name('mentor.training');
    Route::get('/mentor/help', App\Livewire\Mentor\HelpSupport::class)->name('mentor.help');
}); 