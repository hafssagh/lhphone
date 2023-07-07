<?php

namespace App\Http\Livewire\Absence;

use App\Models\User;
use App\Models\Absence;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Historique extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $search = "";

    public $selectedAbsenceIds  = [];
    public $selectedMonth ;

    public function render()
    {
        $user = Auth::user();
        $manager = $user->last_name;
        $query = Absence::orderBy('date', 'DESC');
    
        if ($manager == 'ELMOURABIT' || $manager == 'Bélanger') {
            $query->whereHas('users', fn ($q) => $q->where('group', 1));
        } elseif ($manager == 'Essaid') {
            $query->whereHas('users', fn ($q) => $q->where('group', 2));
        }
    
        $absences = $query->when($this->selectedMonth !== null && $this->selectedMonth != "all", function ($q) {
            return $q->whereMonth('date', $this->selectedMonth);
        })->when($this->search, function ($q) {
            return $q->whereHas('users', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        })->paginate(14);
    
        return view('livewire.absence.historique', [
            "absences" => $absences,
            "users" => User::select('id', 'first_name', 'last_name')->get(),
        ])->extends("layouts.master")->section("contenu");
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
          
            $this->selectedAbsenceIds = [];
        }
    }
}
