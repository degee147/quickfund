<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Jobs\ScoreLoanJob;
use Illuminate\Http\Request;
use App\Jobs\ProcessLoanScoring;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'reason' => 'required|string|max:255',
            'duration' => 'required|integer|min:1', // e.g., in months
        ]);


        $loan = Loan::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'reason' => $request->reason,
            'duration' => $request->duration,
            'status' => 'pending',
        ]);

        //autoscoring
        Queue::push(new ProcessLoanScoring($loan));

        return response()->json([
            'message' => 'Loan submitted successfully',
            'loan' => $loan
        ], 201);
    }

    public function score(Request $request, Loan $loan)
    {
        if (($loan->status !== 'pending') or !empty('scored_at')) {
            return response()->json(['message' => 'Loan already scored or processed.'], 400);
        }

        // Dispatch job to queue
        Queue::push(new ProcessLoanScoring($loan));

        return response()->json([
            'message' => 'Loan scoring has been queued.',
            'loan_id' => $loan->id
        ]);
    }

    public function notifications(Request $request)
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => $notifications
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
