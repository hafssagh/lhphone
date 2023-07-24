<?php

namespace App\Http\Livewire\Appointment;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appoint;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Appointment extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $state;

    public $search = "";
    public $selectedStatus;

    public $newAppointment = [];
    public $editAppointment = [];

    public $selectedId;

    public $currentPage = PAGELIST;
    
    public function render()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;

        $query = Appoint::query();

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

        $appointment = $query->orderBy('created_at', 'desc')->paginate(9);

        $currentMonth = Carbon::now()->format('Y-m');
        $usersQuery = User::select('id', 'first_name', 'last_name')
            ->where('company', 'h2f')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->whereNotExists(function ($query)  use ($currentMonth) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
            })
            ->orderBy('last_name')->paginate(9);


        return view('livewire.appointment.index', ['appointment' => $appointment, 'users' => $usersQuery])->extends("layouts.master")
            ->section("contenu");
    }

    public function goToaddAppointment()
    {
        $this->newAppointment = "";
        $this->currentPage = PAGECREATEFORM;
    }

   public function addNewAppointment()
    {
        $this->validate([
            'newAppointment.prospect' => 'required|unique:appointments,prospect',
            'newAppointment.adresse' => 'required',
            'newAppointment.date_rdv' => 'required',
            'newAppointment.cr' => 'required',
            'newAppointment.dep' => 'required|numeric',
            'newAppointment.num_fix' => 'nullable|numeric',
            'newAppointment.num_mobile' => 'nullable|numeric',
        ], [
            'newAppointment.prospect.required' => "Le nom du prospect est requis.",
            'newAppointment.prospect.unique' => "Le nom du prospect doit être unique.",
            'newAppointment.adresse.required' => "L'adresse du prospect est requis.",
            'newAppointment.date_rdv.required' => "La date du rendez-vous est requise.",
            'newAppointment.cr.required' => "Le crénaut du rendez-vous est requis.",
            'newAppointment.dep.numeric' => "Le département doit contenir que des chiffres.",
            'newAppointment.dep.required' => "Le département est requis.",
            'newAppointment.num_fix.required' => "Le numéro fixe doit contenir que des chiffres.",
            'newAppointment.num_mobile.required' => "Le numéro mobile doit contenir que des chiffres.",
        ]);

        $appoint = new Appoint();

        $user = Auth::user();
        $role = $user->roles->first()->name;

        if ($role == 'Agent') {
            $appoint->user_id = $user->id;
        } else {
            $appoint->user_id = $this->newAppointment["user"];
        }
        
        $appoint->state = $this->newAppointment["state"] = "0";
        $appoint->date_prise = $this->newAppointment["date_prise"] = date('Y-m-d');
        $appoint->date_rdv = $this->newAppointment["date_rdv"] ;
        $appoint->cr = $this->newAppointment["cr"] ;
        $appoint->date_confirm = $this->newAppointment["date_confirm"] ?? null;
        $appoint->prospect = $this->newAppointment["prospect"];
        $appoint->adresse = $this->newAppointment["adresse"];
        $appoint->dep = $this->newAppointment["dep"];
        $appoint->num_fix = $this->newAppointment["num_fix"] ?? null;
        $appoint->num_mobile = $this->newAppointment["num_mobile"] ?? null;
        $appoint->commentaire = $this->newAppointment["commentaire"] ?? null;
        $appoint->retour = $this->newAppointment["retour"] ?? null;

        $appoint->save();

        $this->goToListeAppointments();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un nouveau rendez-vous a été ajouté avec succès!"]);
    }


    public function goToListeAppointments()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }

    
    public function editAppointment($id)
    {
        $this->editAppointment = Appoint::with("users")->find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function updateAppointment()
    {
        $appoint = Appoint::find($this->editAppointment["id"]);
        $appoint->fill($this->editAppointment);
        if ($appoint->state == '1' || $appoint->state == '-1' || $appoint->state == '-2' || $appoint->state == '-3') {
            $appoint->date_confirm = now()->toDateString();
        }
        $appoint->save();
        CalculChallenge();
        CalculPrime();
        $this->goToListeAppointments();
        $this->dispatchBrowserEvent("showSuccessMessage");
    }
}
