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

class GenerateLoanPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $interest = round($this->loan->amount * ($this->loan->interest / 100), 2);
        $emi = ($this->loan->amount / $this->loan->terms);

        $passedNoOfMonths = $this->loan->issued_on->diffInMonths(now());

        for($i = 0; $i < $this->loan->terms; $i++) {
            if( $i > $passedNoOfMonths) {
                $interest = 0;
            }
            $termDueDate = $this->loan->issued_on->addMonths($i + 1);
            LoanPayment::create([
                'patron_id' => $this->loan->patron_id,
                'loan_id' => $this->loan->id,
                'amount' => $emi,
                'interest' => $interest,
                'total' => $emi + $interest,
                'due' => $emi + $interest,
                'due_date' => $termDueDate,
                'month' => $termDueDate->month,
                'year' => $termDueDate->year,
                'term' => $i + 1,
            ]);
        }
    }
}
