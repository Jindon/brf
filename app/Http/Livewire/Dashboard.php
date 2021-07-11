<?php

namespace App\Http\Livewire;

use App\Models\Patron;
use App\Models\Payment;
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
    public $patrons = [];

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

    protected function paymentReportQuery($overall = false)
    {
        return Payment::query()
            ->selectRaw("SUM(due) as total_due, SUM(total) as total_amount, SUM(fine) as total_fine, SUM(paid) as total_paid")
            ->when($this->filter['month'] && !$overall, function($query, $month) {
                $query->where('month', $this->filter['month']);
            })
            ->when($this->filter['year'] && !$overall, function($query, $year) {
                $query->where('year', $this->filter['year']);
            });
    }

    public function patronsDueQuery()
    {
        return Patron::query()
            ->join('payments', function($join) {
                $join->on('patrons.id', 'payments.patron_id')
                    ->where('payments.due', '>', 0);
            })
            ->selectRaw("SUM(payments.due) as total_due, patrons.*")
            ->groupBy("patrons.id");
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'paymentReport' => $this->paymentReportQuery()->first(),
            'overallReport' => $this->paymentReportQuery(true)->first(),
            'patronsWithDues' => $this->patronsDueQuery()->get()
        ]);
    }
}
