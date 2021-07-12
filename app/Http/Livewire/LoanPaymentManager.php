<?php

namespace App\Http\Livewire;

use App\Models\LoanPayment;
use App\Models\Patron;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class LoanPaymentManager extends Component
{
    use WithPagination;

    public $filter = [
        'patronId' => null,
        'month' => null,
        'year' => null,
        'status' => 'unpaid',
        'fine' => 'all'
    ];
    public $months = [];
    public $years = [];
    public $patrons = [];
    public $selectedPayment = null;
    public $amount = 0;

    public function mount()
    {
        for ($i = 1; $i < 13; $i++) {
            $this->months[] = [
                'value' => $i,
                'label' => Carbon::create()->month($i)->format('M')
            ];
        }

        $this->years = Payment::query()
            ->selectRaw("year")
            ->groupBy('year')
            ->get()->map(function($payment) {
                return $payment->year;
            });
        $this->patrons = Patron::get(['id', 'name']);

        $this->filter['month'] = now()->month;
        $this->filter['year'] = now()->year;
    }

    public function selectPayment($paymentId)
    {
        $this->selectedPayment = LoanPayment::findOrFail($paymentId);
        $this->amount = $this->selectedPayment->due;
    }

    public function cancel()
    {
        $this->selectedPayment = null;
    }

    public function makePayment()
    {
        if($this->amount > $this->selectedPayment->due) {
            $this->addError('amount', 'Cannot pay more');
            return false;
        }
        if($this->amount < 10) {
            $this->addError('amount', 'Cannot pay less than 10');
            return false;
        }
        $this->selectedPayment->due = $this->selectedPayment->due - $this->amount;
        $this->selectedPayment->paid = $this->selectedPayment->paid + $this->amount;
        $this->selectedPayment->paid_on = now();
        $this->selectedPayment->save();

        $this->cancel();
    }

    public function paymentsQuery()
    {
        return LoanPayment::with(['loan', 'patron'])
            ->when($this->filter['patronId'], function($query, $patronId) {
                $query->where('patron_id', $patronId);
            })
            ->when($this->filter['month'], function($query, $month) {
                $query->where('month', $month);
            })
            ->when($this->filter['year'], function($query, $year) {
                $query->where('year', $year);
            })
            ->when($this->filter['status'], function($query, $status) {
                if ($status == 'unpaid') {
                    $query->where('due', '>', 0);
                }
                if ($status == 'paid') {
                    $query->where('due', '=', 0);
                }
            })
            ->when($this->filter['fine'], function($query, $fine) {
                if ($fine == 'yes') {
                    $query->where('fine', '>', 0);
                }
                if ($fine == 'no') {
                    $query->where('fine', '=', 0);
                }
            })
            ->oldest('due_date');
    }

    public function render()
    {
        $payments = $this->paymentsQuery()->paginate(15);
        return view('livewire.loan-payment-manager', [
            'payments' => $payments
        ]);
    }
}
