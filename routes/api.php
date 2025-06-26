<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\Admin\LoanApprovalController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/loans', [LoanController::class, 'index']);
    Route::post('/loans/{loan}/repay', [LoanController::class, 'repay']);
    Route::get('/loans/{loan}', [LoanController::class, 'show']);
    Route::post('/loans', [LoanController::class, 'store']);
    Route::put('/loans/{loan}', [LoanController::class, 'update']); // Update loan
    Route::delete('/loans/{loan}', [LoanController::class, 'destroy']); // Delete loan
    Route::get('/notifications', [LoanController::class, 'notifications']);

    Route::post('/repayments/simulate', [RepaymentController::class, 'simulate']);

    Route::middleware([AdminMiddleware::class])
        ->group(function () {
            Route::post('/loans/{loan}/score', [LoanController::class, 'score']);
            Route::post('/loans/{loan}/approve', [LoanApprovalController::class, 'approve']);
            Route::post('/loans/{loan}/reject', [LoanApprovalController::class, 'reject']);
        });
});
