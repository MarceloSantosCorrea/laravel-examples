<?php

use App\Http\Controllers\Api\Authentication\LoginController;
use App\Http\Controllers\Api\Todo\DeleteTodoController;
use App\Http\Controllers\Api\Todo\ListTodoController;
use App\Http\Controllers\Api\Todo\ShowTodoController;
use App\Http\Controllers\Api\Todo\StoreTodoController;
use App\Http\Controllers\Api\Todo\UpdateTodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user', fn(Request $request) => $request->user());

    Route::prefix('todos')->group(function () {
        Route::get('/', ListTodoController::class);
        Route::post('/', StoreTodoController::class);
        Route::get('{todo}', ShowTodoController::class);
        Route::put('{todo}', UpdateTodoController::class);
        Route::delete('{todo}', DeleteTodoController::class);
    });
});
