<?php

namespace App\Http\Livewire\Paiment;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Prelevement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PrelevementSalary extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public $isAddPrelevement;
    public $newPrelevement = [];
    public $editPrelevement = [];

    public $editUser = [];


    protected $rules = [
        "newPrelevement.user" => "required",
        "newPrelevement.prelevement" => "required",
        "newPrelevement.motif" => "nullable",
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        if (auth()->check()) {
            $user = Auth::user();
            $manager = $user->last_name;

            $prelevement = Prelevement::query()
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
                $prelevements = $prelevement->paginate(10);
                $users = $usersQuery->get();
            } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
                $prelevements = $prelevement->whereHas('users', fn ($q) => $q->where('group', 1))
                    ->paginate(10);
                $users = $usersQuery->where('group', 1)->get();
            } elseif ($manager == 'Essaid') {
                $prelevements = $prelevement->whereHas('users', fn ($q) => $q->where('group', 2))
                    ->paginate(10);
                $users = $usersQuery->where('group', 2)->get();
            } elseif ($manager == 'Hdimane') {
                $prelevements = $prelevement->whereHas('users', fn ($q) => $q->where('company', 'h2f'))
                    ->paginate(10);
                $users = $usersQuery->where('company', 'h2f')->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })->get();
            } else {
                $prelevements = $prelevement->paginate(10);
                $users = $usersQuery->get();
            }
        } else {
            return redirect()->route('login');
        }
        return view('livewire.paiment.prelevement', ['users' => $users, 'prelevements' => $prelevements])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function toggleShowAddForm()
    {
        if ($this->isAddPrelevement) {
            $this->isAddPrelevement = false;
            $this->newPrelevement = [];
        } else {
            $this->isAddPrelevement = true;
        }
    }

    public function goToListe()
    {
        $this->dispatchBrowserEvent("closeModal");
    }

    public function addNewPrelevement()
    {
        $this->validate();

        $prelevement = new prelevement();
        if (array_key_exists('motif', $this->newPrelevement)) {
            $prelevement->motif = $this->newPrelevement["motif"];
        } else {
            $prelevement->motif = null;
        }
        $prelevement->prelevement = $this->newPrelevement["prelevement"];
        $prelevement->user_id = $this->newPrelevement["user"];
        $prelevement->save();

        $user = User::find($prelevement->user_id);

        if ($user) {
            $debitSalary = $this->newPrelevement["prelevement"];

            $user->salary = $user->salary  - $debitSalary;
            $user->save();
        }

        $this->newPrelevement = [];
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un prelevementment de salaire a été ajouté avec succès!"]);
    }
}
