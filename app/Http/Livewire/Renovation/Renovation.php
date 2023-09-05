<?php

namespace App\Http\Livewire\Renovation;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Renovations;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class Renovation extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $state;

    public $search = "";
    public $selectedStatus;

    public $newRenovation = [];
    public $editRenovation = [];

    public $selectedId;

    public $currentPage = PAGELIST;

    public function render()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $role = $user->roles->first()->name;
            $manager = $user->last_name;

            $query = Renovations::query();

            if ($this->selectedStatus !== null && $this->selectedStatus !== "all") {
                $query->where('state', $this->selectedStatus);
            }

            if ($role == 'Agent') {
                $query->where('user_id', $user->id)
                    ->when($this->search, function ($query, $search) {
                        return $query->whereHas('users', function ($query) use ($search) {
                            $query->where('prospect', 'like', '%' . $search . '%')
                                ->orWhere('dep', 'like', '%' . $search . '%')
                                ->orWhere('date_rdv', 'like', '%' . $search . '%');
                        });
                    });
            } else {
                $query->when($this->search, function ($query, $search) {
                    $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('prospect', 'like', '%' . $search . '%')
                            ->orWhere('dep', 'like', '%' . $search . '%')
                            ->orWhere('date_rdv', 'like', '%' . $search . '%');
                    });
                });
            }


            $renovations = $query->orderBy('created_at', 'desc')->paginate(10);

            $currentMonth = Carbon::now()->format('Y-m');
            $usersQuery = User::select('id', 'first_name', 'last_name')
                ->where('company', 'lh')
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })->whereNotExists(function ($query)  use ($currentMonth) {
                    $query->select(DB::raw(1))
                        ->from('resignations')
                        ->whereRaw('resignations.user_id = users.id')
                        ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
                })
                ->orderBy('last_name');

                if ($manager == 'EL MESSIOUI') {
                    $users = $usersQuery->get();
                    $renovations = $query->paginate(9);
                } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
                    $users = $usersQuery->where('group', 1)->get();
                    $renovations = $query->whereHas('users', fn ($q) => $q->where('group', 1))
                        ->paginate(9);
                } elseif ($manager == 'Essaid') {
                    $users = $usersQuery->where('group', 2)->get();
                    $renovations = $query->whereHas('users', fn ($q) => $q->where('group', 2))
                        ->paginate(9);
                } else {
                    $users = $usersQuery->get();
                    $renovations = $query->paginate(7);
                }
        } else {
            return redirect()->route('login');
        }


        return view('livewire.renovation.index', ['renovations' => $renovations, 'users' => $users])->extends("layouts.master")
            ->section("contenu");
    }

    public function goToaddRenovation()
    {
        $this->newRenovation = "";
        $this->currentPage = PAGECREATEFORM;
    }

    public function addNewRenovation()
    {
        $this->validate([
            'newRenovation.prospect' => 'required|unique:renovation,prospect',
            'newRenovation.adresse' => 'required',
            'newRenovation.date_rdv' => 'nullable',
            'newRenovation.cr' => 'nullable',
            'newRenovation.state' => 'required',
            'newRenovation.dep' => 'required|numeric',
            'newRenovation.num_fix' => 'nullable|numeric',
            'newRenovation.num_mobile' => 'nullable|numeric',
            'newRenovation.rappel' => 'nullable',
        ], [
            'newRenovation.prospect.required' => "Le nom du prospect est requis.",
            'newRenovation.prospect.unique' => "Le nom du prospect doit être unique.",
            'newRenovation.adresse.required' => "L'adresse du prospect est requis.",
            'newRenovation.state.required' => "Le statut est requis.",
            'newRenovation.dep.numeric' => "Le département doit contenir que des chiffres.",
            'newRenovation.dep.required' => "Le département est requis.",
            'newRenovation.num_fix.required' => "Le numéro fixe doit contenir que des chiffres.",
            'newRenovation.num_mobile.required' => "Le numéro mobile doit contenir que des chiffres.",
        ]);

        $renovation = new Renovations();

        $user = Auth::user();
        $role = $user->roles->first()->name;

        if ($role == 'Agent') {
            $renovation->user_id = $user->id;
        } else {
            $renovation->user_id = $this->newRenovation["user"];
        }

        $renovation->state = $this->newRenovation["state"];
        $renovation->date_prise = $this->newRenovation["date_prise"] = date('Y-m-d');
        $renovation->date_rdv = $this->newRenovation["date_rdv"] ?? null;
        $renovation->cr = $this->newRenovation["cr"] ?? null;
        $renovation->date_confirm = $this->newRenovation["date_confirm"] ?? null;
        $renovation->prospect = $this->newRenovation["prospect"];
        $renovation->adresse = $this->newRenovation["adresse"];
        $renovation->dep = $this->newRenovation["dep"];
        $renovation->num_fix = $this->newRenovation["num_fix"] ?? null;
        $renovation->num_mobile = $this->newRenovation["num_mobile"] ?? null;
        $renovation->commentaire = $this->newRenovation["commentaire"] ?? null;
        $renovation->retour = $this->newRenovation["retour"] ?? null;
        $renovation->rappel = $this->newRenovation["rappel"] ?? null;

        $renovation->save();

        $this->goToListeRenovation();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un nouveau rendez-vous a été ajouté avec succès!"]);
    }


    public function goToListeRenovation()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }


    public function editRenovation($id)
    {
        $this->editRenovation = Renovations::with("users")->find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function updateRenovation()
    {
        $renovation = Renovations::find($this->editRenovation["id"]);
        $renovation->fill($this->editRenovation);
        if ($renovation->state == '1' || $renovation->state == '-1' || $renovation->state == '-2' || $renovation->state == '-3') {
            $renovation->date_confirm = now()->toDateString();
        }
        $renovation->save();
        CalculChallenge();
        CalculPrime();
        $this->goToListeRenovation();
        $this->dispatchBrowserEvent("showSuccessMessage");
    }
}
