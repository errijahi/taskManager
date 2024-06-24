<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/create/{projectId}', [TaskController::class, 'store'])->name('task.store');
Route::get('/edit/{projectId}/{taskId}', [TaskController::class, 'edit'])->name('task.edit');
Route::post('/update/{projectId}/{taskId}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/delete/{projectId}/{taskId}', [TaskController::class, 'destroy'])->name('task.destroy');
Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');

Route::post('/project/create/{projectId}', [ProjectController::class, 'store'])->name('project.store');
