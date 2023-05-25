<?php

namespace App\Http\Livewire\Salary;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Salary extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $selectedSocieties = [];
    public $search = "";

    public function render()
    {
        $salary = User::where("first_name", "like", "%" . $this->search . "%")
        ->orWhere("last_name", "like", "%" . $this->search . "%")
        ->orderBy('last_name')->where('company', $this->selectedSocieties)->paginate(6);

        $challenge = User::whereNot('challenge', '0')
        ->where(function ($query) {
            $query->orderBy('last_name')
                ->where('company', $this->selectedSocieties)
                ->where("first_name", "like", "%" . $this->search . "%")
                ->orWhere("last_name", "like", "%" . $this->search . "%");
        })
        ->get();

        $prime = User::whereNot('challenge', '0')
        ->where(function ($query) {
            $query->orderBy('last_name')
                ->where('company', $this->selectedSocieties)
                ->where("first_name", "like", "%" . $this->search . "%")
                ->orWhere("last_name", "like", "%" . $this->search . "%");
        })
        ->get();

        return view('livewire.salary', 
        ["salary" => $salary , "challenge" => $challenge , "prime" => $prime])
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function toggleCheckbox($society)
    {
        $this->selectedSocieties = $society;
    }

}
