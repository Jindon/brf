<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PublicReport extends Component
{
    public $unlocked = false;

    public $pin = '';

    public function unlockReport()
    {
        if ($this->pin == config('app.public_pin')) {
            $this->unlocked = true;
        }
    }

    public function clear()
    {
        $this->pin = '';
    }

    public function render()
    {
        return view('livewire.public-report')
            ->layout('layouts.guest');
    }
}
