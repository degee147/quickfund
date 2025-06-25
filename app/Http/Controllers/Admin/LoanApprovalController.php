<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LoanApprovalController extends Controller
{
    public function approve(Loan $loan): JsonResponse
    {
        $loan->update([
            'status' => 'approved',
            'approved_by_admin' => true,
        ]);

        return response()->json([
            'message' => 'Loan approved manually.',
            'loan' => $loan,
        ]);
    }

    public function reject(Loan $loan): JsonResponse
    {
        $loan->update([
            'status' => 'rejected',
            'approved_by_admin' => false,
        ]);

        return response()->json([
            'message' => 'Loan rejected manually.',
            'loan' => $loan,
        ]);
    }
}
