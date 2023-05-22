<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Absences extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    public $newAbsence = [];
    public $editAbsence = [];

    protected $rules = [
        "newAbsence.user" => "required",
        "newAbsence.abs_hours" => "required|numeric|lte:8",
        "newAbsence.date" => "required",
    ];

    protected $messages = [
        'newAbsence.user.required' => "Le nom de l'agent est requis.",
        'newAbsence.abs_hours.required' => "Les heures d'absence sont requises.",
        'newAbsence.abs_hours.lte' => "Les heures d'absence ne doivent pas dépasser 8 heures.",
        'newAbsence.date.required' => "La date d'absence est requise.",
    ];


    public function render()
    {
        $currentMonth = Carbon::now()->format('Y-m');

        return view('livewire.absence.index', [
            "absences" => Absence::query()
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->latest()->paginate(4),
            "users" => User::select('id', 'first_name', 'last_name')->get(),
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }


    public function goToaddAbsence()
    {
        $this->newAbsence = "";
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToListeAbsence()
    {
        $this->currentPage = PAGELIST;
        $this->editAbsence = [];
    }

    public function addNewAbsence()
    {
        $this->validate();
        $absence = new Absence;
        $absence->date = $this->newAbsence["date"];
        $absence->abs_hours = $this->newAbsence["abs_hours"];
        if (array_key_exists('justification', $this->newAbsence)) {
            $absence->justification = $this->newAbsence["justification"];
        } else {
            $absence->justification = null;
        }
        $absence->user_id = $this->newAbsence["user"];
        $absence->save();
        
        workHours();
        AbsSalary();

        $this->goToListeAbsence();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un nouveau absence a été ajouté avec succès!"]);
    }

    public function goToEditAbsence($id)
    {
        $this->editAbsence = Absence::with("users")->find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function updateAbsence(){
        $absence = Absence::find($this->editAbsence["id"]);
        $absence->fill($this->editAbsence);
        $absence->save();
        $this->goToListeAbsence();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Absence mise à jour avec succès!"]);
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

    public function deleteAbsence($id)
    {
        Absence::destroy($id);
        workHours();
        AbsSalary();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Départ supprimé avec succès!"]);
    }
}
