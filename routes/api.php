<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/tasks/filter', [TasksController::class, 'filter']);
Route::get('/categories/with-task-count', [CategoriesController::class, 'indexWithTaskCount']);

Route::apiResource('users', UsersController::class);
Route::apiResource('tasks', TasksController::class);
Route::apiResource('categories', CategoriesController::class);

Route::patch('/users/{user}/admin', [UsersController::class, 'setAdmin']);
Route::patch('/users/{user}/email', [UsersController::class, 'changeEmail']);



