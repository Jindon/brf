<?php

namespace App\Http\Livewire;

use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Patron;
use Livewire\Component;

class LoanReport extends Component
{
    public $patrons = [];

    public function mount()
    {
        $this->patrons = Patron::get(['id', 'name']);
    }

    protected function loanReportQuery()
    {
        $summary = LoanPayment::query()
            ->selectRaw("
                SUM(due) as total_due,
                SUM(fine) as total_fine,
                SUM(paid) as total_paid,
                SUM(interest) as total_interest
            ")
            ->first();
        $summary->total_issued = Loan::sum('amount');
        return $summary;
    }

    public function patronsDueQuery()
    {
        return Patron::query()
            ->leftJoin('loan_payments', function($join) {
                $join->on('patrons.id', 'loan_payments.patron_id')
                    ->where('loan_payments.due', '>', 0);
            })
            ->selectRaw("
                SUM(loan_payments.due) as total_due,
                patrons.*
            ")
            ->groupBy("patrons.id")
            ->orderBy('total_due', 'desc');
    }

    public function render()
    {
        return view('livewire.loan-report', [
            'overallReport' => $this->loanReportQuery(),
            'patronsWithDues' => $this->patronsDueQuery()->get()
        ]);
    }
}
