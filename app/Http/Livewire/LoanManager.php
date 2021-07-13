<?php

namespace App\Http\Livewire;

use App\Jobs\GenerateLoanPayments;
use App\Models\Loan;
use App\Models\Patron;
use Livewire\Component;

class LoanManager extends Component
{
    public $form = [
        'patron_id' => null,
        'amount' => 0,
        'interest' => 1,
        'fine' => 0,
        'issued_on' => null
    ];
    public $filter = [
        'status' => 'all'
    ];
    public $patrons = [];

    protected $rules = [
        'form.patron_id' => 'required|exists:patrons,id',
        'form.amount' => 'required',
        'form.interest' => 'required',
        'form.fine' => 'nullable|numeric',
    ];

    public function issueLoan()
    {
        $this->validate();
        $loan = Loan::create($this->form);
        GenerateLoanPayments::dispatch($loan);
        $this->form['patron_id'] = null;
    }

    public function cancel()
    {
        $this->form['patron_id'] = null;
    }

    public function delete(Loan $loan)
    {
        if(!$loan->paid) {
            $loan->payments()->delete();
            $loan->delete();
        }
    }

    public function mount()
    {
        $this->patrons = Patron::get(['id', 'name']);
        $this->form['issued_on'] = now()->format('d-m-Y');
        $this->form['amount'] = config('app.default_loan_amount');
        $this->form['fine'] = config('app.default_loan_fine');
    }

    public function loanQuery()
    {
        return Loan::with('patron')
            ->when($this->filter['status'], function ($query, $status) {
                if ($status == 'pending') {
                    $query->select('loans.*')
                        ->join('loan_payments', 'loan_payments.loan_id', 'loans.id')
                        ->groupBy('loans.id')
                        ->havingRaw('SUM(loan_payments.due) > 0');
                }
                if ($status == 'completed') {
                    $query->select('loans.*')
                        ->join('loan_payments', 'loan_payments.loan_id', 'loans.id')
                        ->groupBy('loans.id')
                        ->havingRaw('SUM(loan_payments.due) = 0');
                }
            })
            ->latest();
    }

    public function render()
    {
        $loans = $this->loanQuery()->paginate(15);
        return view('livewire.loan-manager', [
            'loans' => $loans
        ]);
    }
}
