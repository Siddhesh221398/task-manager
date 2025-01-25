<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class); 
    Route::get('/my-tasks', [TaskController::class, 'myTasks']);
    Route::apiResource('tasks', TaskController::class);
    Route::post('/tasks/{task}/comments', [TaskCommentController::class, 'store']);
    Route::get('/tasks/{task}/comments', [TaskCommentController::class, 'index']);
    Route::get('/tasks/export/{format}', [TaskController::class, 'export'])
    ->where('format', 'csv|xlsx');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});
