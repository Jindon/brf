<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateFines implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $day;

    public function __construct($day = null)
    {
        $this->day = $day ?? now();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pendingPayments = Payment::query()
            ->with(['plan'])
            ->when(!config('app.compound_fine'), function($query) {
                $query
                ->where('month', $this->day->month)
                ->where('year', $this->day->year)
                ->where('fine', 0);
            })
            ->where('due', '>', 0)
            ->get();

        foreach ($pendingPayments as $pendingPayment) {
            if($this->day->gt($pendingPayment->due_date)) {
                $pendingPayment->fine += $pendingPayment->plan->fine_amount;
                $pendingPayment->total += $pendingPayment->plan->fine_amount;
                $pendingPayment->due += $pendingPayment->plan->fine_amount;
                $pendingPayment->save();
            }
        }
    }
}
