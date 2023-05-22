<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Salary extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $selectedSocieties = [];

    public function render()
    {
        return view('livewire.salary', 
        ["salary" =>  User::orderBy('last_name')
        ->where('company', $this->selectedSocieties)
        ->paginate(10)
        ])
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function toggleCheckbox($society)
    {
        $this->selectedSocieties = $society;
    }

}
