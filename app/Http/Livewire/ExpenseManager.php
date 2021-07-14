<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use Livewire\Component;

class ExpenseManager extends Component
{
    public $form = [
        'type' => '',
        'amount' => 0,
        'date' => null,
        'paid' => 0
    ];
    public $sortBy = 'date';
    public $order = 'desc';
    public $types = [];

    public function createExpense()
    {
        if($this->form['amount']) {
            Expense::create($this->form);
            $this->form['type'] = '';
            $this->notify('Expense added successfully');
        }
    }

    public function cancel()
    {
        $this->form['type'] = '';
    }

    public function delete(Expense $expense)
    {
        $expense->delete();
        $this->notify('Expense deleted successfully');
    }

    public function markPaid(Expense $expense)
    {
        $expense->paid = 1;
        $expense->save();
        $this->notify('Expense marked paid successfully');
    }

    public function mount()
    {
        $this->form['date'] = now()->format('d-m-Y');
        $this->types = config("app.expense_type");
    }

    public function expenseQuery()
    {
        return Expense::query()
            ->orderBy($this->sortBy, $this->order);
    }

    public function render()
    {
        return view('livewire.expense-manager', [
            'expenses' => $this->expenseQuery()->paginate(15)
        ]);
    }
}
