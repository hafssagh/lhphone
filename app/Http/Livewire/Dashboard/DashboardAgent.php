<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardAgent extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-agent')->extends("layouts.master")
        ->section("contenu");
    }
}
