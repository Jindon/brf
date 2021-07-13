<?php

namespace App\Http\Livewire;

use App\Models\Patron;
use Livewire\Component;

class ContributionSummary extends Component
{
    public $years = [];
    public $months = [];
    public $filter = [
        'year' => null
    ];

    public function mount()
    {
        $this->filter['year'] = now()->year;
    }

    public function patronsDueQuery()
    {
        return Patron::query()
            ->with([
                'payments' => function($query) {
                    $query->orderBy('month', 'asc')
                    ->when($this->filter['year'], function($query, $year) {
                        $query->where('year', $year);
                    });
                }
            ])->get()
            ->map(function($patron) {
                $paymentDetails = [];
                foreach ($patron->payments as $payment) {
                    $paymentDetails[$payment->month] = $payment->paid;
                }
                $patron->payment_details = $paymentDetails;
                return $patron->only('name', 'id', 'payment_details');
            });
    }

    public function render()
    {
        return view('livewire.contribution-summary', [
            'patrons' => $this->patronsDueQuery()
        ]);
    }
}
