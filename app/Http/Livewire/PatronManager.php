<?php

namespace App\Http\Livewire;

use App\Models\Patron;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;

class PatronManager extends Component
{
    use WithPagination;

    public $form = [
        'name' => '',
        'email' => '',
        'joined_on' => '',
        'starting_balance' => 0
    ];
    public $selectedPatron = null;
    public $addNew = false;

    public function selectPatron(Patron $patron)
    {
        $this->addNew = false;
        $this->selectedPatron = $patron;
        $this->form = [
            'name' => $patron->name,
            'email' => $patron->email,
            'joined_on' => $patron->joined_on->format('d-m-Y'),
            'starting_balance' => optional($patron->startingBalance)->amount ?? 0
        ];
    }

    public function addNewPatron()
    {
        $this->addNew = true;
        $this->unSelectPatron();
    }

    public function closeAddForm()
    {
        $this->addNew = false;
        $this->clearForm();
    }

    public function unSelectPatron()
    {
        $this->selectedPatron = null;
        $this->clearForm();
    }

    public function savePatron()
    {
        if ($this->selectedPatron) {
            $this->selectedPatron->update(Arr::except($this->form, 'starting_balance'));
            $this->selectedPatron->startingBalance()->updateOrCreate([
                'patron_id' => $this->selectedPatron->id
            ],[
                'amount' => $this->form['starting_balance']
            ]);
            $this->unSelectPatron();
        } else {
            $patron = Patron::create(Arr::except($this->form, 'starting_balance'));
            $patron->startingBalance()->updateOrCreate([
                'patron_id' => $patron->id
            ],[
                'amount' => $this->form['starting_balance']
            ]);
            $this->clearForm();
        }

        $this->notify('Patron saved successfully');
    }

    public function clearForm()
    {
        $this->form['name'] = '';
        $this->form['email'] = '';
        $this->form['joined_on'] = '';
        $this->form['starting_balance'] = 0;
    }

    public function render()
    {
        $patrons = Patron::latest()->paginate(15);
        return view('livewire.patron-manager', [
            'patrons' => $patrons
        ]);
    }
}
