<?php

namespace App\Jobs;

use App\Models\Patron;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\PlanLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $currentPlan;
    protected $date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($date = null)
    {
        $this->date = $date ?? now();
        $this->currentPlan = Plan::latest()->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $patrons = Patron::get();
        $count = 0;
        foreach($patrons as $patron) {
            if(!$patron->monthPaymentExists($this->date->month, $this->date->year)) {
                $date = clone $this->date;
                Payment::create([
                    'patron_id' => $patron->id,
                    'plan_id' => $this->currentPlan->id,
                    'amount' => $this->currentPlan->amount,
                    'fine' => 0,
                    'total' => $this->currentPlan->amount,
                    'paid' => 0,
                    'due' => $this->currentPlan->amount,
                    'due_date' => $date->setDay(15),
                    'month' => $date->month,
                    'year' => $date->year,
                    'paid_on' => null
                ]);
                $count++;
            }
        }

        if($count) {
            PlanLog::create([
                'plan_id' => $this->currentPlan->id,
                'month' => $this->date->month,
                'year' => $this->date->year,
                'payments_generated' => $count
            ]);
        }
    }
}
