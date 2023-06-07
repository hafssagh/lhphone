<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashRH extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashRH')->extends("layouts.master")
            ->section("contenu");
    }
}
