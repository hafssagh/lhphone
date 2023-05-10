<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $isBtnAddClicked = false;

    public $newUser = [];

    public function render()
    {
        return view('livewire.users.index', [
            "users" => User::paginate(4)
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToaddUser(){
        $this->isBtnAddClicked =true;
    }

    public function goToListeUser(){
        $this->isBtnAddClicked =false;
    }

    public function addUser(){
        dump($this->newUser);
    }
   
}
