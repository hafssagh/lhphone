<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;

class Historique extends Component
{
    public function render()
    {
        return view('livewire.absence.historique' , [
            "absences" => Absence::query() ->orderBy('date', 'desc') ->paginate(4),
            "users" => User::select('id', 'first_name' , 'last_name')->get(),
        ])
        ->extends("layouts.master")
        ->section("contenu");
    }
}
