<?php

namespace App\Http\Livewire\Absence;

use App\Models\User;
use App\Models\Absence;
use Livewire\Component;
use Livewire\WithPagination;

class Historique extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $selectedAbsenceIds  = [];
    public $selectedMonth ;

    public function render()
    {

        if ($this->selectedMonth === null || $this->selectedMonth == "all") {
            // Logic when all months are selected
            $absences = Absence::orderBy('date','DESC')->paginate(10);
        } else {
            $absences = Absence::orderBy('date','DESC')->whereMonth('date', $this->selectedMonth)->get();
        }
        return view('livewire.absence.historique', [
            "absences" => $absences,
            "users" => User::select('id', 'first_name', 'last_name')->get(),
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }


    public function confirmDelete()
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer, êtes-vous sûr de continuer?",
            "type" => "warning",
        ]]);
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedAbsenceIds)) {
            Absence::whereIn('id', $this->selectedAbsenceIds)->delete();
            workHours();
            AbsSalary();
            // Perform any other necessary actions after deletion
            // ...

            // Clear the selected user IDs
            $this->selectedAbsenceIds = [];
        }
    }
}
