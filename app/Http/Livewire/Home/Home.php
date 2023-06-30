<?php

namespace App\Http\Livewire\Home;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mails;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        $manager = $user->last_name;

        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $userAgent = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->where('users.group', '1')
                ->orderBy('users.last_name')
                ->select('users.first_name', 'users.last_name', 'users.photo')
                ->paginate(9);
        } elseif ($manager == 'Essaid') {
            $userAgent = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->where('users.group', '2')
                ->orderBy('users.last_name')
                ->select('users.first_name', 'users.last_name', 'users.photo')
                ->paginate(9);
        } else {
            $userAgent = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->orderBy('users.last_name')
                ->select('users.first_name', 'users.last_name', 'users.photo')
                ->paginate(9);
        }

        $userManager = User::join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->where('roles.name', 'Manager')
            ->select('users.first_name', 'users.last_name', 'users.photo')
            ->get();

        $userAdmin = User::join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->where('roles.name', 'Administrateur')
            ->where('users.first_name', 'Mahdi')
            ->select('users.first_name', 'users.last_name', 'users.photo')
            ->get();

        $userAdmin2 = User::join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->where('roles.name', 'Administrateur')
            ->where('users.first_name', 'Hafssa')
            ->select('users.first_name', 'users.last_name', 'users.photo')
            ->get();

        $userDirecteur = User::join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->where('roles.name', 'Super Administrateur')
            ->select('users.first_name', 'users.last_name', 'users.photo')
            ->get();



        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $userGet = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->where('users.group', '1')
                ->orderBy('users.company', 'desc')
                ->orderBy('users.group')
                ->select('users.first_name', 'users.last_name', 'users.photo', 'users.company', 'users.group')
                ->get();
        } elseif ($manager == 'Essaid') {
            $userGet = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->where('users.group', '2')
                ->orderBy('users.company', 'desc')
                ->orderBy('users.group')
                ->select('users.first_name', 'users.last_name', 'users.photo', 'users.company', 'users.group')
                ->get();
        } else {
            $userGet = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->orderBy('users.company', 'desc')
                ->orderBy('users.group')
                ->select('users.first_name', 'users.last_name', 'users.photo', 'users.company', 'users.group')
                ->get();
        }

        $today = Carbon::now(); // Get the current date and time using Carbon
        $rappel = Mails::query()
            ->where('user_id', '=', $user->id)
            ->whereDate('rappel', $today)
            ->orderBy('rappel')
            ->get();

        $rappelManager = Mails::query()
            ->whereDate('rappel', $today)
            ->orderBy('rappel');

        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $rappelManager->whereHas('users', fn ($q) => $q->where('group', 1));
        } elseif ($manager == 'Essaid') {
            $rappelManager->whereHas('users', fn ($q) => $q->where('group', 2));
        } else {
            $rappelManager->get();
        }

        $rappelManager = $rappelManager->get();



        return view('livewire.home',  [
            "userGet" => $userGet, "userAgent" => $userAgent, "userAdmin" => $userAdmin,
            "userAdmin2" => $userAdmin2, "userManager" => $userManager, "userDirecteur" => $userDirecteur,
            "rappel" => $rappel, "rappelManager" => $rappelManager
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }
}
