<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;


// ユーザー向けルート（`admin` の prefix なし）
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::get('/sheets', [SheetController::class, 'sheets'])->name('sheets');

// **管理者向けルート（`admin` の prefix を適用）**
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('movies/{movieId}/schedules/create', [AdminScheduleController::class, 'create'])->name('schedules.create');
    Route::post('movies/{movieId}/schedules/store', [AdminScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/movies', [AdminMovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/create', [AdminMovieController::class, 'create'])->name('movies.create');
    Route::get('/movies/{id}', [AdminMovieController::class, 'show'])->name('movies.show');
    Route::patch('/movies/{id}/update', [AdminMovieController::class, 'update'])->name('movies.update');
    Route::post('/movies/store', [AdminMovieController::class, 'store'])->name('movies.store');
    Route::delete('/movies/{id}/destroy', [AdminMovieController::class, 'destroy'])->name('movies.destroy');

    Route::get('schedules', [AdminScheduleController::class, 'index'])->name('schedules.index');
    Route::get('schedules/{id}', [AdminScheduleController::class, 'show'])->name('schedules.show');
    Route::get('schedules/{scheduleId}/edit', [AdminScheduleController::class, 'edit'])->name('schedules.edit');
    Route::get('/movies/{id}/edit', [AdminMovieController::class, 'edit'])->name('movies.edit');
    Route::delete('schedules/{id}/destroy', [AdminScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::patch('schedules/{id}/update', [AdminScheduleController::class, 'update'])->name('schedules.update');
    
});

Route::patch('/movies/{id}/update', [AdminMovieController::class, 'update'])->name('movies.update');