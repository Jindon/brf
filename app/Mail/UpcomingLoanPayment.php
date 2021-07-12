<?php

namespace App\Mail;

use App\Models\Patron;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpcomingLoanPayment extends Mailable
{
    use Queueable, SerializesModels;

    public $patron;
    public $dueDate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Patron $patron, $dueDate)
    {
        $this->patron = $patron;
        $this->dueDate = $dueDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.loan-payment')
            ->with([
                'patronName' => $this->patron->name,
                'duePayments' => $this->patron->dueLoanPayments($this->dueDate)->get(),
                'dueTotal' => $this->patron->dueLoanPayments($this->dueDate)->sum('due')
            ]);
    }
}
