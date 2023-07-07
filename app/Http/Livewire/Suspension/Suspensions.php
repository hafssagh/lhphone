<?php

namespace App\Http\Livewire\Suspension;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Suspension;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Suspensions extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public $currentPage = PAGELIST;

    public $newSuspension = [];
    public $editSuspension = [];

    protected $rules = [
        'newSuspension.user' => 'required',
        'newSuspension.date_debut' => 'required',
        'newSuspension.date_fin' => 'required',
    ];

    protected $messages = [
        'newSuspension.user.required' => "Le nom de l'agent est requis.",
        'newSuspension.date_debut.required' => "La date d'arrêt est requise.",
        'newSuspension.date_fin.required' => "La date d'arrêt est requise.",
    ];


    public function render()
    {
        Carbon::setLocale("fr");
        $user = Auth::user();
        $manager = $user->last_name;

        $query = Suspension::query()
            ->when($this->search, function ($query, $search) {
                return $query->whereHas('users', function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                });
            })
            ->latest();

        $usersQuery = User::select('id', 'first_name', 'last_name')
            ->whereHas('roles', function ($query) {
                $query->whereNot('name', 'super administrateur');
            })->orderBy('last_name');

        if ($manager == 'EL MESSIOUI') {
            $suspensions = $query->get();
            $users = $usersQuery->get();
        } elseif ($manager == 'ELMOURABIT' || $manager == 'Bélanger') {
            $suspensions = $query->whereHas('users', fn ($q) => $q->where('group', 1));
            $users = $usersQuery->where('group', 1)->get();
        } elseif ($manager == 'Essaid') {
            $suspensions = $query->whereHas('users', fn ($q) => $q->where('group', 2));
            $users = $usersQuery->where('group', 2)->get();
        } elseif ($manager == 'Hdimane') {
            $suspensions = $query->whereHas('users', fn ($q) => $q->where('company', 'h2f'));
            $users = $usersQuery->where('company', 'h2f')->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();
        } else {
            $suspensions = $query->get();
            $users = $usersQuery->get();
        }
   
        return view('livewire.suspension.index', ["suspensions" => $suspensions, "users" => $users,])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToaddSuspension()
    {
        $this->newSuspension = "";
        $this->currentPage = PAGECREATEFORM;
    }

    public function addNewSuspension()
    {
        $this->validate();
        $suspension = new Suspension;
        $suspension->date_debut = $this->newSuspension["date_debut"];
        $suspension->date_fin = $this->newSuspension["date_fin"];
        if (array_key_exists('cause', $this->newSuspension)) {
            $suspension->cause = $this->newSuspension["cause"];
        } else {
            $suspension->cause = null;
        }
        $suspension->user_id = $this->newSuspension["user"];
        $suspension->save();

        workHours();
        AbsSalary(); 

        $this->goToListeSuspension();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un nouveau Suspension a été ajouté avec succès!"]);
    }

    public function goToListeSuspension()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
        $this->editSuspension = [];
    }
}
