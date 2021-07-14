<?php

namespace App\Http\Livewire;

use App\Jobs\GenerateLoanPayments;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Patron;
use App\Models\Payment;
use App\Models\StartingBalance;
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
    public $loading = false;
    public $amountInAccount = 0;
    public $limitError = null;

    protected $rules = [
        'form.patron_id' => 'required|exists:patrons,id',
        'form.amount' => 'required',
        'form.interest' => 'required',
        'form.fine' => 'nullable|numeric',
    ];

    public function mount()
    {
        $this->patrons = Patron::get(['id', 'name']);
        $this->form['issued_on'] = now()->format('d-m-Y');
        $this->form['amount'] = config('app.default_loan_amount');
        $this->form['fine'] = config('app.default_loan_fine');
        $this->amountInAccount = $this->getAmountInAccount();
    }

    public function updatedFormAmount($value)
    {
        if($this->amountInAccount < $this->form['amount']) {
            $this->limitError = 'Insufficient balance to issue loan';
        } else {
            $this->limitError = null;
        }
    }

    protected function getAmountInAccount()
    {
        $expense = Expense::where('paid', 1)->sum('amount');
        $pendingLoan = Loan::sum('amount') - LoanPayment::where('due', 0)->sum('amount');
        $totalContribution = (float) Payment::where('due', 0)->sum('total') + StartingBalance::sum('amount');
        $interestCollected = (float) LoanPayment::where('due', '>', 0)->sum('interest');

        return $totalContribution + $interestCollected - $pendingLoan - $expense;
    }

    public function issueLoan()
    {
        $this->loading = true;
        $this->validate();

        if($this->amountInAccount < $this->form['amount']) {
            $this->limitError = 'Insufficient balance to issue loan';
            $this->loading = false;
            return;
        }

        $loan = Loan::create($this->form);
        GenerateLoanPayments::dispatch($loan);
        $this->form['patron_id'] = null;
        $this->notify('Loan issued successfully');
        $this->limitError = null;
        $this->loading = false;
    }

    public function cancel()
    {
        $this->form['patron_id'] = null;
        $this->limitError = null;
    }

    public function delete(Loan $loan)
    {
        if(!$loan->paid) {
            $loan->payments()->delete();
            $loan->delete();
        }
        $this->notify('Loan deleted successfully');
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
