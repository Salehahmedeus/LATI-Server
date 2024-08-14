<?php

use App\Http\Controllers\ServerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [UserController::class, 'register']);
Route::post('login',[UserController::class,'login']);



Route::middleware('auth:api')->group(function () {

    Route::post('logout', [UserController::class, 'logout']);
    Route::get('user', [UserController::class, 'user']);
    Route::post('refresh', [UserController::class, 'refresh']);
    Route::post('ServerStore', [ServerController::class, 'store']);
    Route::get('Servers', [ServerController::class, 'index']);
    Route::get('Show/{code}', [ServerController::class, 'show']);
    Route::put('update/{id}', [ServerController::class, 'update']);
    Route::delete('delete/{id}', [ServerController::class, 'destroy']);
});
