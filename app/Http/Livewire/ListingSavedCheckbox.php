<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListingSavedCheckbox extends Component
{

    protected $listeners = ['listingSaved' => 'render'];

    public function render()
    {
        $saved = auth()->user()->savedListings()->count();
        return view('livewire.listing-saved-checkbox', compact('saved'));
    }
}
