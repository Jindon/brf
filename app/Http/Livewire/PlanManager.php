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
    public $latestPlan = null;

    public function mount()
    {
        $this->latestPlan = Plan::latest()->first();
        $this->amount = optional($this->latestPlan)->amount ?? 0;
        $this->fine_amount = optional($this->latestPlan)->fine_amount ?? 0;
    }

    public function updateAmount()
    {
        if(
            $this->latestPlan
            && $this->amount == $this->latestPlan->amount
            && $this->fine_amount == $this->latestPlan->fine_amount
        ) {
            return;
        }

        $this->latestPlan = Plan::create([
            'amount' => $this->amount,
            'fine_amount' => $this->fine_amount
        ]);
        $this->notify('Plan details updated successfully');
    }

    public function render()
    {
        $planLogs = PlanLog::with('plan')->latest()->paginate(15);
        return view('livewire.plan-manager', [
            'planLogs' => $planLogs
        ]);
    }
}
