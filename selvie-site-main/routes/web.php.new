<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/teams/{team}/meetings/calendar', App\Http\Livewire\School\MeetingCalendar::class)
        ->name('meetings.calendar')
        ->middleware('can:view-meetings,team');

    Route::get('/teams/{team}/tasks', App\Http\Livewire\School\TaskList::class)
        ->name('tasks.index')
        ->middleware('can:view-tasks,team');

    // Training routes
    Route::get('/teams/{team}/trainings', App\Http\Livewire\School\TrainingList::class)
        ->name('trainings.index')
        ->middleware('can:view-trainings,team');

    Route::get('/teams/{team}/trainings/{training}', App\Http\Livewire\School\TrainingView::class)
        ->name('trainings.view')
        ->middleware('can:view-trainings,team');

    Route::get('/teams/{team}/trainings/{training}/modules/{module}', App\Http\Livewire\School\ModuleView::class)
        ->name('module.view')
        ->middleware('can:view-trainings,team');
}); 