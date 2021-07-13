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

class GenerateLoanInterest implements ShouldQueue
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
            ->whereDate('due_date', $this->date->addMonths(1))
            ->where('interest', 0)
            ->where('due', '>', 0)
            ->get();

        if(!$pendingPayments) {
            return;
        }

        foreach ($pendingPayments as $pendingPayment) {
            $interest = round($pendingPayment->loan->amount * ($pendingPayment->loan->interest / 100), 2);

            $pendingPayment->interest += $interest;
            $pendingPayment->total += $interest;
            $pendingPayment->due += $interest;
            $pendingPayment->save();
        }
    }
}
