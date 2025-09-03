<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SparepartController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',    [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::resource('/spareparts', SparepartController::class)->middleware(['auth:sanctum', 'role:admin']);
Route::resource('/users', UserController::class)->middleware(['auth:sanctum', 'role:admin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
});
