<?php

namespace App\Http\Livewire\Absence;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;
use Livewire\WithPagination;

class Absences extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public $currentPage = PAGELIST;

    public $newAbsence = [];
    public $editAbsence = [];


    protected $messages = [
        'newAbsence.user.required' => "Le nom de l'agent est requis.",
        'newAbsence.abs_hours.required' => "Les heures d'absence sont requises.",
        'newAbsence.abs_hours.lte' => "Les heures d'absence ne doivent pas dépasser 8 heures.",
        'editAbsence.abs_hours.required' => "Les heures d'absence sont requises.",
        'editAbsence.abs_hours.lte' => "Les heures d'absence ne doivent pas dépasser 8 heures.",
        'editAbsence.date.required' => "La date d'absence est requise.",
    ];

    public function rules()
    {
        if ($this->currentPage == PAGEEDITFORM) {
            return [
                "editAbsence.abs_hours" => "required|numeric|lte:8",
                "editAbsence.date" => "required",
            ];
        }
        return [
            "newAbsence.user" => "required",
            "newAbsence.abs_hours" => "required|numeric|lte:8",
        ];
    }

    public function render()
    {
        $currentMonth = Carbon::now()->format('Y-m');

        return view('livewire.absence.index', [
            "absences" => Absence::query()
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%');
                    });
                })->latest()->paginate(5),
            "users" => User::select('id', 'first_name', 'last_name')->whereHas('roles', function ($query) {
                $query->whereNot('name', 'super administrateur');
            })->get(),
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
        $this->resetValidation();
        $this->currentPage = PAGELIST;
        $this->editAbsence = [];
    }

    public function addNewAbsence()
    {
        $this->validate();
        $absence = new Absence;
        $absence->date = $this->newAbsence["date"] = date('Y-m-d');
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

    public function updateAbsence()
    {
         $this->validate(); 
        $absence = Absence::find($this->editAbsence["id"]);
        $absence->abs_hours = $this->editAbsence["abs_hours"];
        $absence->date = $this->editAbsence["date"];
        if (array_key_exists('justification', $this->editAbsence)) {
            $absence->justification = $this->editAbsence["justification"];
        } else {
            $absence->justification = null;
        }
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
