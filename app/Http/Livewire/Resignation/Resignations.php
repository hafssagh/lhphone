<?php

namespace App\Http\Livewire\Resignation;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Resignation;
use Livewire\WithPagination;



class Resignations extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public $isAddResignation;
    public $newResignation = [];
    public $editResignation = [];

    public $editUser = [];


    protected $rules = [
        "newResignation.user" => "required",
        "newResignation.motive" => "nullable",
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        return view('livewire.resignation.index', [
            "resignations" => Resignation::query()
                ->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%');
                    });
                })->latest()->paginate(10),
            "users" => User::select('id', 'first_name', 'last_name')->whereHas('roles', function ($query) {
                $query->whereNot('name', 'super administrateur');
            })->orderBy('last_name')->get(),
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function toggleShowAddForm()
    {
        if ($this->isAddResignation) {
            $this->isAddResignation = false;
            $this->newResignation = [];
        } else {
            $this->isAddResignation = true;
        }
    }

    public function goToListe()
    {
        $this->dispatchBrowserEvent("closeModal");
    }

    public function addNewResignation()
    {
        $this->validate();
    
        $resignation = new Resignation();
        $resignation->date = $this->newResignation["date"] = date('Y-m-d');
        if (array_key_exists('motive', $this->newResignation)) {
            $resignation->motive = $this->newResignation["motive"];
        } else {
            $resignation->motive = null;
        }
        $resignation->user_id = $this->newResignation["user"];
        $resignation->save();
    
        $user = User::find($resignation->user_id);
    
        if ($user) {
            $newPassword = bcrypt('resignation');
    
            $user->password = $newPassword;
            $user->save();
        }
    
        $this->newResignation = [];
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un nouveau départ a été ajouté avec succès!"]);
    }
    

    public function editResignation($resignationId)
    {
        $this->editResignation = Resignation::with("users")->find($resignationId)->toArray();
        $this->dispatchBrowserEvent("showModal");
    }

    public function updateResignation()
    {

        $resignation = Resignation::find($this->editResignation["id"]);

        $resignation->fill($this->editResignation);

        $resignation->save();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Départ mise à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeModal");
    }

    public function confirmDelete($id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer, êtes-vous sûr de continuer?",
            "type" => "warning",
            "data" => [
                "resignation_id" => $id
            ]
        ]]);
    }

    public function deleteResignation($id)
    {
        Resignation::destroy($id);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Départ supprimé avec succès!"]);
    }

}
