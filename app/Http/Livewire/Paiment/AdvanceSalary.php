<?php

namespace App\Http\Livewire\Paiment;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Avance;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AdvanceSalary extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public $isAddAdvance;
    public $newAdvance = [];
    public $editAdvance = [];

    public $editUser = [];


    protected $rules = [
        "newAdvance.user" => "required",
        "newAdvance.advance" => "required",
        "newAdvance.motif" => "nullable",
    ];
    
    public function render()
    {
        Carbon::setLocale("fr");
    
        $user = Auth::user();
        $manager = $user->last_name;
    
        $avance = Avance::query()
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
            })
            ->orderBy('last_name');
    
        if ($manager == 'EL MESSIOUI') {
            $avances = $avance->paginate(10);
            $users = $usersQuery->get();
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $avances = $avance->whereHas('users', fn ($q) => $q->where('group', 1))
                ->paginate(10);
            $users = $usersQuery->where('group', 1)->get();
        } elseif ($manager == 'Essaid') {
            $avances = $avance->whereHas('users', fn ($q) => $q->where('group', 2))
                ->paginate(10);
            $users = $usersQuery->where('group', 2)->get();
        } elseif ($manager == 'Hdimane') {
            $avances = $avance->whereHas('users', fn ($q) => $q->where('company', 'h2f'))
                ->paginate(10);
            $users = $usersQuery->where('company', 'h2f')->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();
        } else {
            $avances = $avance->paginate(10);
            $users = $usersQuery->get();
        }

        return view('livewire.paiment.advance-salary' , ['users' => $users , 'avances' => $avances])
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function toggleShowAddForm()
    {
        if ($this->isAddAdvance) {
            $this->isAddAdvance = false;
            $this->newAdvance = [];
        } else {
            $this->isAddAdvance = true;
        }
    }

    public function goToListe()
    {
        $this->dispatchBrowserEvent("closeModal");
    }

    public function addNewAdvance()
    {
        $this->validate();

        $advance = new Avance();
        if (array_key_exists('motif', $this->newAdvance)) {
            $advance->motif = $this->newAdvance["motif"];
        } else {
            $advance->motif = null;
        }
        $advance->advance = $this->newAdvance["advance"];
        $advance->user_id = $this->newAdvance["user"];
        $advance->save();

        $user = User::find($advance->user_id);

        if ($user) {
            $debitSalary = $this->newAdvance["advance"];

            $user->salary = $user->salary  - $debitSalary;
            $user->save();
        }

        $this->newAdvance = [];
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un avancement de salaire a été ajouté avec succès!"]);
    }

}
