<?php

namespace App\Http\Livewire\Production;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;
use App\Models\Suspension;
use App\Models\Renovations;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;

class Production3 extends Component
{
    public $users1;
    public $users2;
    public $renovation1;
    public $renovation2;
    public $absence;
    public $absence2;

    public $resignation1;
    public $resignation2;

    public $suspension1;
    public $suspension2;

    public $weekDates;
    public $weekDatesWithoutWeekends;
    public $nextWeekDatesWithoutWeekends;
    public $months;

    public function mount()
    {
        $currentWeekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
        $currentWeekEnd = Carbon::now()->endOfWeek()->format('Y-m-d');



        $this->users1 = User::whereNotExists(function ($query) use ($currentWeekStart, $currentWeekEnd) {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
        })
            ->where('company', 'lh')
            ->where('group', '1')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();

        $this->users2 = User::whereNotExists(function ($query)  use ($currentWeekStart, $currentWeekEnd) {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
        })->where('company', 'lh')
            ->where('group', '2')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();

        $this->renovation1 = Renovations::select('user_id', 'date_confirm', 'date_prise', 'date_rdv', 'cr', 'state')
            ->join('users', 'renovation.user_id', '=', 'users.id')
            ->whereNot('state','rapp')
            ->where('users.group', '1')
            ->get();

        $this->renovation2 = Renovations::select('user_id', 'date_confirm', 'date_prise', 'date_rdv', 'cr', 'state')
            ->join('users', 'renovation.user_id', '=', 'users.id')
            ->whereNot('state','rapp')
            ->where('users.group', '2')
            ->get();


        $this->absence = Absence::select('user_id', 'date', 'abs_hours')
            ->join('users', 'absences.user_id', '=', 'users.id')
            ->where('users.group', '1')
            ->groupBy('user_id', 'date', 'abs_hours')
            ->get();

        $this->absence2 = Absence::select('user_id', 'date', 'abs_hours')
            ->join('users', 'absences.user_id', '=', 'users.id')
            ->where('users.group', '2')
            ->groupBy('user_id', 'date', 'abs_hours')
            ->get();

        $this->resignation1 = Resignation::select('user_id', 'date')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.group', '1')
            ->groupBy('user_id', 'date')
            ->get();

        $this->resignation2 = Resignation::select('user_id', 'date')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.group', '2')
            ->groupBy('user_id', 'date')
            ->get();

        $this->suspension1 = Suspension::select('user_id', 'date_debut', 'date_fin')
            ->join('users', 'suspension.user_id', '=', 'users.id')
            ->where('users.group', '1')
            ->groupBy('user_id', 'date_debut', 'date_fin')
            ->get();

        $this->suspension2 = Suspension::select('user_id', 'date_debut', 'date_fin')
            ->join('users', 'suspension.user_id', '=', 'users.id')
            ->where('users.group', '2')
            ->groupBy('user_id', 'date_debut', 'date_fin')
            ->get();

        $this->weekDates = fetchWeekDates();
        $this->weekDatesWithoutWeekends = fetchWeekDatesWithoutWeekend();
        $this->nextWeekDatesWithoutWeekends = fetchNextWeekDatesWithoutWeekend();
        $this->months = fetchMonthWeeks();
    }

    public function render()
    {
        return view('livewire.production.production3')    ->extends("layouts.app")
        ->section("contenu2");
    }
}
