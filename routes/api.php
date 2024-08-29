<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('project')->name('project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/show/{project}', [ProjectController::class, 'show']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::match(['put', 'patch'], '/{project}', [ProjectController::class, 'update']);
    Route::delete('/{project}', [ProjectController::class, 'destroy']);
});

Route::prefix('task')->name('task.')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/show/{task}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::match(['put', 'patch'], '/{task}', [TaskController::class, 'update']);
    Route::delete('/{task}', [TaskController::class, 'destroy']);
});
