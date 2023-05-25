<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    
    public function render()
    {
        $userAgent = User::join('user_role', 'users.id', '=', 'user_role.user_id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'agent')
        ->orderBy('users.last_name')
        ->select('users.first_name','users.last_name','users.photo')
        ->paginate(9);

        $userManager = User::join('user_role', 'users.id', '=', 'user_role.user_id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'Manager')
        ->select('users.first_name','users.last_name','users.photo')
        ->get();

        $userAdmin = User::join('user_role', 'users.id', '=', 'user_role.user_id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'Administrateur')
        ->select('users.first_name','users.last_name','users.photo')
        ->get();

        $userDirecteur = User::join('user_role', 'users.id', '=', 'user_role.user_id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'super administrateur')
        ->select('users.first_name','users.last_name','users.photo')
        ->get();

        $userGet = User::join('user_role', 'users.id', '=', 'user_role.user_id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'agent')
        ->orderBy('users.last_name')
        ->select('users.first_name','users.last_name','users.photo','users.company')
        ->get();


        return view('livewire.home',  ["userGet" => $userGet , "userAgent" => $userAgent , "userAdmin" => $userAdmin ,"userManager" => $userManager ,"userDirecteur" => $userDirecteur])
        ->extends("layouts.master")
        ->section("contenu");
    }
    
}