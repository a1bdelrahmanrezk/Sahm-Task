<?php

use Illuminate\Http\Request;
use App\Modules\Tasks\TaskController;
use Illuminate\Support\Facades\Route;
use App\Modules\Authentication\AuthenticationController;



Route::controller(AuthenticationController::class)->prefix('auth')->group(function () {
    Route::post('/register',  'register');
    Route::post('/login',  'login');
});



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthenticationController::class, 'logout']);
    Route::apiResource('tasks', TaskController::class);
    Route::post('tasks/{task}/complete', [TaskController::class, 'complete']);
});
