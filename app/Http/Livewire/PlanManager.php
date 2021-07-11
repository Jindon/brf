<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use App\Models\PlanLog;
use Livewire\Component;
use Livewire\WithPagination;

class PlanManager extends Component
{
    use WithPagination;

    public $amount = 0;
    public $fine_amount = 0;

    public function mount()
    {
        $this->amount = optional(Plan::latest()->first())->amount ?? 0;
        $this->fine_amount = optional(Plan::latest()->first())->fine_amount ?? 0;
    }

    public function updateAmount()
    {
        return Plan::create([
            'amount' => $this->amount,
            'fine_amount' => $this->fine_amount
        ]);
    }

    public function render()
    {
        $planLogs = PlanLog::with('plan')->latest()->paginate(15);
        return view('livewire.plan-manager', [
            'planLogs' => $planLogs
        ]);
    }
}
