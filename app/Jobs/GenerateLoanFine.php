<?php

namespace App\Jobs;

use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateLoanFine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date;

    public function __construct($date = null)
    {
        $this->date = $date ?? now();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pendingPayments = LoanPayment::query()
            ->with(['loan'])
            ->whereDate('due_date', '<', $this->date)
            ->where('fine', 0)
            ->where('due', '>', 0)
            ->get();

        foreach ($pendingPayments as $pendingPayment) {

            $pendingPayment->fine += $pendingPayment->loan->fine;
            $pendingPayment->total += $pendingPayment->loan->fine;
            $pendingPayment->due += $pendingPayment->loan->fine;
            $pendingPayment->save();
        }
    }
}
