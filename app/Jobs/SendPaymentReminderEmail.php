<?php

namespace App\Jobs;

use App\Mail\UpcomingContributionPayment;
use App\Models\Patron;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Patron::query()
            ->with('duePayments')
            ->whereHas('duePayments')
            ->get()
        ->map(function($patron) {
            Mail::to($patron->email)
                ->queue(new UpcomingContributionPayment($patron));
        });
    }
}
