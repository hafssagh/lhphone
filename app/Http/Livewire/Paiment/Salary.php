<?php

namespace App\Http\Livewire\Paiment;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Salary extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $selectedCompany = [];
    public $search = "";

    public function render()
    {
        if ($this->selectedCompany === null || $this->selectedCompany == "all") {
            $salary = User::where(function ($query) {
                $query->where("first_name", "like", "%" . $this->search . "%")
                    ->orWhere("last_name", "like", "%" . $this->search . "%");
            })
                ->join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->whereNot('roles.name', 'Super Administrateur')
                ->orderBy('last_name')
                ->paginate(6);
        } else {
            $salary = User::where(function ($query) {
                $query->where('company', $this->selectedCompany)
                    ->where(function ($query) {
                        $query->where("first_name", "like", "%" . $this->search . "%")
                            ->orWhere("last_name", "like", "%" . $this->search . "%");
                    });
            })
                ->join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->whereNot('roles.name', 'Super Administrateur')
                ->orderBy('last_name')
                ->paginate(6);
        }

        return view('livewire.paiment.salary',  ["salary" => $salary])
            ->extends("layouts.master")
            ->section("contenu");
    }

    
}
