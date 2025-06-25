<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Jobs\ScoreLoanJob;
use Illuminate\Http\Request;

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
        ScoreLoanJob::dispatch($loan);
        return response()->json([
            'message' => 'Loan submitted successfully',
            'loan' => $loan
        ], 201);
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
