<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RepaymentController extends Controller
{
    public function simulate(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:1',
            'channel' => 'required|in:card,virtual_account',
        ]);

        $user = Auth::user();

        $loan = Loan::where('id', $request->loan_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Mock logic: assume success
        $repayment = Repayment::create([
            'loan_id' => $loan->id,
            'user_id' => $user->id,
            'amount' => $request->amount,
            'channel' => $request->channel,
            'reference' => strtoupper(Str::random(12)),
            'paid_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Repayment simulated successfully.',
            'data' => $repayment
        ]);
    }
}
