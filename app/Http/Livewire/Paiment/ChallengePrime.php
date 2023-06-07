<?php

namespace App\Http\Livewire\Paiment;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ChallengePrime extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $selectedSocieties = [];
    public $search = "";

    public function render()
    {
        $challenge = User::whereNot('challenge', '0')
        ->select('first_name','last_name','challenge')
        ->where(function ($query) {
            $query->orderBy('last_name')
                ->where('company', $this->selectedSocieties)
                ->where("first_name", "like", "%" . $this->search . "%")
                ->orWhere("last_name", "like", "%" . $this->search . "%");
        })
        ->paginate(6);

        $prime = User::whereNot('prime', '0')
        ->select('first_name','last_name','prime')
        ->where(function ($query) {
            $query->orderBy('last_name')
                ->where('company', $this->selectedSocieties)
                ->where("first_name", "like", "%" . $this->search . "%")
                ->orWhere("last_name", "like", "%" . $this->search . "%");
        })
        ->paginate(6);

        return view('livewire.paiment.challenge-prime', 
        ["challenge" => $challenge , "prime" => $prime])
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function toggleCheckbox($society)
    {
        $this->selectedSocieties = $society;
    }  
    
}
