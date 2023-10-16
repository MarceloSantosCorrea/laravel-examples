<?php

use App\Http\Controllers\Api\Authentication\LoginJWTController;
use App\Http\Controllers\Api\Todo\DeleteTodoController;
use App\Http\Controllers\Api\Todo\ListTodoController;
use App\Http\Controllers\Api\Todo\ShowTodoController;
use App\Http\Controllers\Api\Todo\StoreTodoController;
use App\Http\Controllers\Api\Todo\UpdateTodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginJWTController::class);

Route::middleware('auth:api')->group(function () {
    Route::get('user', fn(Request $request) => $request->user());
    Route::post('invalid-token', function (Request $request) {

        auth()->invalidate();

//        app('tymon.jwt.blacklist')->add("token in payload instance");
//        $payload = auth()->payload();
//        app('tymon.jwt.blacklist')->add($payload);
    });

    Route::prefix('todos')->group(function () {
        Route::get('/', ListTodoController::class);
        Route::post('/', StoreTodoController::class);
        Route::get('{todo}', ShowTodoController::class);
        Route::put('{todo}', UpdateTodoController::class);
        Route::delete('{todo}', DeleteTodoController::class);
    });
});

Route::post('clear', function () {
    cache()->flush();
    //app('tymon.jwt')->flush();
});
