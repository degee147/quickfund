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

    Route::post('/loans', [LoanController::class, 'store']);
    Route::get('/notifications', [LoanController::class, 'notifications']);

    Route::post('/repayments/simulate', [RepaymentController::class, 'simulate']);

    Route::prefix('admin')
        ->middleware([AdminMiddleware::class])
        ->group(function () {
            Route::post('/loans/{loan}/score', [LoanController::class, 'score']);
            Route::patch('/loans/{loan}/approve', [LoanApprovalController::class, 'approve']);
            Route::patch('/loans/{loan}/reject', [LoanApprovalController::class, 'reject']);
        });
});
