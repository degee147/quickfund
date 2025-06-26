<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Jobs\ScoreLoanJob;
use Illuminate\Http\Request;
use App\Jobs\ProcessLoanScoring;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LoanController extends Controller
{
    use AuthorizesRequests;

    // List all loans (admin or own loans)
    public function index()
    {
        $user = Auth::user();
        $loans = $user->isAdmin()
            ? Loan::with('user')->latest()->get()
            : $user->loans()->latest()->get();

        return response()->json($loans);
    }

    // Show specific loan
    public function show(Loan $loan)
    {
        $this->authorize('view', $loan);
        return response()->json($loan);
    }

    public function repay(Request $request, Loan $loan): JsonResponse
    {
        // dd(['auth_id' => Auth::id(), 'loan id' => $loan->id]);
        // Authorization: Only loan owner or admin can simulate repayment
        // if (Auth::id() !== $loan->user_id && Auth::user()->role !== 'admin') {
        //     abort(403, 'Unauthorized');
        // }

        if ($loan->status !== 'approved') {
            return response()->json(['message' => 'Only approved loans can be repaid.'], 400);
        }

        // Simulate repayment logic
        $repaymentAmount = $loan->amount + ($loan->amount * 0.1); // assume 10% interest
        $loan->status = 'repaid';
        $loan->repaid_at = now();
        $loan->save();

        return response()->json([
            'message' => 'Repayment successful (simulated).',
            'loan_id' => $loan->id,
            'total_paid' => $repaymentAmount,
            'repaid_at' => $loan->repaid_at,
        ]);
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


    // Update loan (admin or editable by user if pending)
    public function update(Request $request, Loan $loan)
    {
        $this->authorize('update', $loan);

        $data = $request->validate([
            'amount' => 'sometimes|numeric|min:1000',
            'purpose' => 'sometimes|string|max:255',
            'tenure' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:pending,approved,rejected',
        ]);

        $loan->update($data);

        return response()->json(['message' => 'Loan updated.', 'loan' => $loan]);
    }

    // Delete loan (only if not processed)
    public function destroy(Loan $loan)
    {
        $this->authorize('delete', $loan);
        $loan->delete();

        return response()->json(['message' => 'Loan deleted.']);
    }

}
