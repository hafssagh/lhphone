<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Map2 extends Component
{
    public function render()
    {
        return view('livewire.map2') ->extends("layouts.master")
        ->section("contenu");;
    }
}
