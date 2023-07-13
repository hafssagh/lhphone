<?php

namespace App\Http\Livewire\Paiment;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Salary extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $selectedCompany = [];
    public $search = "";

    public $showRib = false;

    public function render()
    {
        $user = Auth::user();
        $manager = $user->last_name;

        $salary = User::where(function ($query) {
            $query->where("first_name", "like", "%" . $this->search . "%")
                ->orWhere("last_name", "like", "%" . $this->search . "%");
        })
            ->when($this->selectedCompany !== null && $this->selectedCompany !== 'all', function ($query) {
                $query->where('company', $this->selectedCompany);
            })
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
                $query->where('group', 1)
                ->where('roles.name', ['Agent']);
            })
            ->when($manager == 'Essaid ', function ($query) {
                $query->where('group', 2)
                ->where('roles.name', ['Agent']);
            })
            ->when($manager == 'Hdimane' , function ($query) {
                $query->where('company', 'h2f')
            ->where('roles.name', ['Agent']);
            })
            ->whereNotIn('roles.name', ['Super Administrateur'])
            ->orderBy('last_name')
            ->paginate(12);

        return view('livewire.paiment.salary',  ["salary" => $salary])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function toggleRibDisplay()
    {
        $this->showRib = !$this->showRib;
    }

}
