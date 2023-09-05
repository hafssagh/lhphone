<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Dashboard3 extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard3') ->extends("layouts.master")
        ->section("contenu");
    }
}
