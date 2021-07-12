<?php

namespace App\Mail;

use App\Models\Patron;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpcomingContributionPayment extends Mailable
{
    use Queueable, SerializesModels;

    public $patron;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Patron $patron)
    {
        $this->patron = $patron;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contribution-payment')
            ->with([
                'patronName' => $this->patron->name,
                'duePayments' => $this->patron->duePayments,
                'dueTotal' => $this->patron->duePayments()->sum('due')
            ]);
    }
}
