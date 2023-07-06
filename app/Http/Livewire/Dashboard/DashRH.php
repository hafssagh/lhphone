<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;

class DashRH extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashRH')->extends("layouts.master")
            ->section("contenu");
    }

    public function cards()
    {

        $usersQuery = User::query();

        $userCount = $usersQuery->whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->count();
        $userslh1 = $usersQuery->where('group', 1);
        $userslh2 = $usersQuery->where('group', 2);
        $usersh2f = $usersQuery->where('company', 'h2f');
        

    }
}
