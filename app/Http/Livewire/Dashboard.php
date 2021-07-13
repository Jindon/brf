<?php

namespace App\Http\Livewire;

use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Patron;
use App\Models\Payment;
use App\Models\StartingBalance;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $filter = [
        'month' => '',
        'year' => '',
    ];

    public $months = [];
    public $years = [];
    public $startingBalance = 0;

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
            ->orderBy('year', 'desc')
            ->get()->map(function($payment) {
                return $payment->year;
            });

        $this->filter['month'] = now()->month;
        $this->filter['year'] = now()->year;
        $this->startingBalance = StartingBalance::sum('amount');
    }

    public function platformReport()
    {
        return [
            'totalContribution' => (float) Payment::where('due', 0)->sum('total') + $this->startingBalance,
            'totalFine' => Payment::where('due', 0)->sum('fine') + LoanPayment::where('due', 0)->sum('fine'),
            'totalLoanIssued' => (float) Loan::sum('amount'),
            'pendingLoan' => Loan::sum('amount') - LoanPayment::where('due', 0)->sum('amount'),
            'interestCollected' => (float) LoanPayment::where('due', '>', 0)->sum('interest')
        ];
    }

    protected function paymentReportQuery($overall = false)
    {
        return Payment::query()
            ->selectRaw("SUM(due) as total_due, SUM(total) as total_amount, SUM(fine) as total_fine, SUM(paid) as total_paid")
            ->when($this->filter['month'] && !$overall, function($query, $month) {
                $query->where('month', $this->filter['month']);
            })
            ->when($this->filter['year'] && !$overall, function($query, $year) {
                $query->where('year', $this->filter['year']);
            })->first();
    }

    public function patronsContributionQuery()
    {
        return Patron::query()
            ->with('startingBalance')
            ->leftJoin('payments', function($join) {
                $join->on('patrons.id', 'payments.patron_id')
                    ->where('payments.due', 0);
            })
            ->selectRaw("SUM(payments.paid) as total_paid, patrons.*")
            ->groupBy("patrons.id")
            ->get()
            ->map(function($patron) {
                $patron->total_paid = $patron->total_paid + optional($patron->startingBalance)->amount;
                return $patron;
            });
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'paymentReport' => $this->paymentReportQuery(),
            'overallReport' => $this->paymentReportQuery(true),
            'patronsContribution' => $this->patronsContributionQuery(),
            'platformReport' => $this->platformReport()
        ]);
    }
}
