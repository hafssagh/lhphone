<?php

namespace App\Http\Livewire\Conge;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Conges;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Conge extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public $currentPage = PAGELIST;

    public $dateDebut;
    public $dateFin;
    public $statut;
    public $utilisateurs = [];

    public function ajouterConges()
    {
        foreach ($this->utilisateurs as $utilisateurId => $isSelected) {
            if ($isSelected) {
                Conges::create([
                    'date_debut' => $this->dateDebut,
                    'date_fin' => $this->dateFin,
                    'statut' => $this->statut,
                    'user_id' => $utilisateurId,
                ]);
            }
        }

        $this->dateDebut = null;
        $this->dateFin = null;
        $this->statut = null;
        $this->utilisateurs = [];

        workHours();
        AbsSalary();
        
        $this->goToListeConge();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un nouveau congé a été ajouté avec succès!"]);
    }

    public function goToaddconge()
    {
        $this->currentPage = PAGECREATEFORM;
    }

    public function render()
    {
        Carbon::setLocale("fr");
        if (auth()->check()) {
            $user = Auth::user();
            $manager = $user->last_name;
            $query = Conges::query()
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
                })->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('resignations')
                        ->whereRaw('resignations.user_id = users.id');
                })->orderBy('last_name');

            if ($manager == 'EL MESSIOUI') {
                $conges = $query->get();
                $users = $usersQuery->get();
            } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
                $conges = $query->whereHas('users', fn ($q) => $q->where('group', 1))->get();
                $users = $usersQuery->where('group', 1)->orWhere('last_name', 'ELMOURABIT')->orWhere('last_name', 'By')->get();
            } elseif ($manager == 'Essaid') {
                $conges = $query->whereHas('users', fn ($q) => $q->where('group', 2))->get();
                $users = $usersQuery->where('group', 2)->orWhere('last_name', 'Essaid')->get();
            } elseif ($manager == 'Hdimane') {
                $conges = $query->whereHas('users', fn ($q) => $q->where('company', 'h2f'));
                $users = $usersQuery->where('company', 'h2f')->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })->get();
            } 
        } else {
            return redirect()->route('login');
        }

        return view('livewire.conge.index', ["conges" => $conges, "users" => $users])->extends("layouts.master")
            ->section("contenu");
    }

    
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function goToListeConge()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }
}
