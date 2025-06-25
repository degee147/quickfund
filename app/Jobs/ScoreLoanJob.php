<?php

namespace App\Jobs;

use App\Models\Loan;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScoreLoanJob implements ShouldQueue
{
    use Queueable;
    public $loan;


    /**
     * Create a new job instance.
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mock rule-based scoring
        $score = rand(300, 900); // Just for example

        $status = $score >= 600 ? 'approved' : 'rejected';

        $this->loan->update([
            'score' => $score,
            'status' => $status,
            'scored_at' => now(),
        ]);
    }
}
