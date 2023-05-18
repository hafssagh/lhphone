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

    public $totalHours;


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

        $today = Carbon::today();
        $firstDayOfMonth = $today->copy()->startOfMonth();
        $workingDays = $this->getWorkingDays($firstDayOfMonth, $today);
        $this->totalHours = $workingDays * 8;

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
    }


    private function getWorkingDays($startDate, $endDate)
    {
        $workingDays = 0;
        while ($startDate <= $endDate) {
            if ($startDate->isWeekday()) {
                $workingDays++;
            }
            $startDate->addDay();
        }
        return $workingDays;
    }

    public function workHours()
    {
        $users = User::all();

        $currentMonth = Carbon::now()->format('Y-m');
        foreach ($users as $user) {
            $totalAbsenceDays = Absence::where('user_id', $user->id)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->sum('abs_hours');

            $workHours = $this->totalHours;

            $user->work_hours = $workHours - $totalAbsenceDays;
            $user->save();
        }
    }
   

    public function AbsSalary()
    {
        $users = User::all();
        foreach ($users as $user) {
            $workHoursMonth =  calculerHeuresTravailParMois();
            $salary_perHour = $user->base_salary /  $workHoursMonth;
            $salary = $salary_perHour * $user->work_hours;
            $user->salary =  round($salary, 0, PHP_ROUND_HALF_UP);
            $user->save();
        }
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

        $this->workHours();
        $this->AbsSalary();

        $this->goToListeAbsence();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Un nouveau absence a été ajouté avec succès!"]);
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
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Départ supprimé avec succès!"]);
    }
}
