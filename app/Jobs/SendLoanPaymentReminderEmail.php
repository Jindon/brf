<?php

namespace App\Jobs;

use App\Mail\UpcomingLoanPayment;
use App\Models\LoanPayment;
use App\Models\Patron;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLoanPaymentReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dueDate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dueDate = now()->addDays(1);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $duePatronIds = LoanPayment::query()
            ->whereDate('due_date', '<=', $this->dueDate)
            ->where('due', '>', 0)
            ->pluck('patron_id')
            ->unique();

        Patron::whereIn('id', $duePatronIds)
            ->get()
            ->map(function($patron) {
                Mail::to($patron->email)
                    ->queue(new UpcomingLoanPayment($patron, $this->dueDate));
            });
    }
}
