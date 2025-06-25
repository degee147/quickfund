<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Admin\LoanApprovalController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::post('/loans', [LoanController::class, 'store']);
});

Route::prefix('admin')
    ->middleware([AdminMiddleware::class])
    ->group(function () {
        Route::patch('/loans/{loan}/approve', [LoanApprovalController::class, 'approve']);
        Route::patch('/loans/{loan}/reject', [LoanApprovalController::class, 'reject']);
    });

