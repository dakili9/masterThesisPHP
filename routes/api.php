<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/', function () {
    return 'alo bre';
});

Route::apiResource('users', UsersController::class);
Route::apiResource('tasks', TasksController::class);
Route::apiResource('categories', CategoriesController::class);
