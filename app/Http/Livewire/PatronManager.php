<?php

namespace App\Http\Livewire;

use App\Models\Patron;
use Livewire\Component;
use Livewire\WithPagination;

class PatronManager extends Component
{
    use WithPagination;

    public $form = [
      'name' => '',
      'email' => '',
      'joined_on' => ''
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
            'joined_on' => $patron->joined_on->format('d-m-Y')
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
        if($this->selectedPatron) {
            $this->selectedPatron->update($this->form);
            $this->unSelectPatron();
            return true;
        }
        Patron::create($this->form);
        $this->clearForm();
        return true;
    }

    public function clearForm()
    {
        $this->form['name'] = '';
        $this->form['email'] = '';
        $this->form['joined_on'] = '';
    }

    public function render()
    {
        $patrons = Patron::latest()->paginate(15);
        return view('livewire.patron-manager', [
            'patrons' => $patrons
        ]);
    }
}
