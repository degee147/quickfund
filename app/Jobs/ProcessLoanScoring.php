<?php

namespace App\Jobs;

use App\Models\Loan;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessLoanScoring implements ShouldQueue
{
    use Queueable;

    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->loan->refresh(); // Make sure it's fresh from DB

        // Mock rule-based scoring logic
        $user = $this->loan->user;

        $score = 0;
        $income = $user->monthly_income ?? 0;
        $amount = $this->loan->amount;

        if ($income >= 200000) {
            $score += 50;
        }

        if ($amount <= $income * 0.5) {
            $score += 30;
        }

        if ($user->email_verified_at) {
            $score += 20;
        }

        $this->loan->score = $score;
        $this->loan->status = $score >= 60 ? 'approved' : 'rejected';
        $this->loan->scored_at = Carbon::now();
        $this->loan->save();

        // Optionally trigger notification
        Notification::create([
            'user_id' => $user->id,
            'type' => 'email',
            'message' => "Your loan has been {$this->loan->status} with a score of $score.",
        ]);

        Log::info("Loan {$this->loan->id} scored: $score");
    }
}
