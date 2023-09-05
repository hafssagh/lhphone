<?php

namespace App\Http\Livewire\Home;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mails;
use Livewire\Component;
use App\Models\Renovations;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    use WithPagination;

    public function render()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $manager = $user->last_name;

            $userAgent = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->when($manager, function ($query, $manager) {
                    switch ($manager) {
                        case 'ELMOURABIT':
                        case 'By':
                            return $query->where('users.group', '1');
                        case 'Essaid':
                            return $query->where('users.group', '2');
                        case 'Hdimane':
                            return $query->where('users.company', 'h2f');
                        default:
                            return $query;
                    }
                })
                ->orderBy('users.last_name')
                ->select('users.first_name', 'users.last_name', 'users.photo')
                ->paginate(9);


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

            $userRh = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'Administrateur')
                ->where('users.first_name', 'Ikram')
                ->select('users.first_name', 'users.last_name', 'users.photo')
                ->get();

            $userDirecteur = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'Super Administrateur')
                ->select('users.first_name', 'users.last_name', 'users.photo')
                ->get();


            $userGet = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('roles.name', 'agent')
                ->when($manager, function ($query, $manager) {
                    switch ($manager) {
                        case 'ELMOURABIT':
                        case 'By':
                            return $query->where('users.group', '1');
                        case 'Essaid':
                            return $query->where('users.group', '2');
                        case 'Hdimane':
                            return $query->where('users.company', 'h2f');
                        default:
                            return $query;
                    }
                })
                ->orderBy('users.company', 'desc')
                ->orderBy('users.group')
                ->select('users.first_name', 'users.last_name', 'users.photo', 'users.company', 'users.group')
                ->get();

            $today = Carbon::now();
            
            $rappel = Renovations::query()
                ->where('user_id', '=', $user->id)
                ->whereDate('rappel', $today)
                ->orderBy('rappel')
                ->get();

            $rappelManager = Renovations::query()
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
        } else {
            return redirect()->route('login');
        }


        return view('livewire.home',  [
            "userGet" => $userGet, "userAgent" => $userAgent, "userAdmin" => $userAdmin,
            "userAdmin2" => $userAdmin2, "userManager" => $userManager, "userDirecteur" => $userDirecteur,
            "rappel" => $rappel, "rappelManager" => $rappelManager, "userRh" => $userRh
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }
}
