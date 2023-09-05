<?php

namespace App\Http\Livewire\Production;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use App\Models\Appoint;
use Livewire\Component;
use App\Models\Suspension;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;

class Production2 extends Component
{
    public $users3;
    public $appoint;
    public $absenceh2f;
    public $resignationh2f;
    public $suspensionh2f;

    public $weekDates;
    public $weekDatesWithoutWeekends;
    public $nextWeekDatesWithoutWeekends;
    public $months;

    public function mount()
    {
        $currentWeekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
        $currentWeekEnd = Carbon::now()->endOfWeek()->format('Y-m-d');


        $this->users3 = User::whereNotExists(function ($query)  use ($currentWeekStart, $currentWeekEnd) {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
        })->where('company', 'h2f')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();



        $this->appoint = Appoint::select('user_id', 'date_confirm', 'date_prise', 'date_rdv', 'cr', 'state')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
            ->get();

        $this->absenceh2f = Absence::select('user_id', 'date', 'abs_hours')
            ->join('users', 'absences.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
            ->groupBy('user_id', 'date', 'abs_hours')
            ->get();

        $this->resignationh2f = Resignation::select('user_id', 'date')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
            ->groupBy('user_id', 'date')
            ->get();


        $this->suspensionh2f = Suspension::select('user_id', 'date_debut', 'date_fin')
            ->join('users', 'suspension.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
            ->groupBy('user_id', 'date_debut', 'date_fin')
            ->get();

        $this->weekDates = fetchWeekDates();
        $this->weekDatesWithoutWeekends = fetchWeekDatesWithoutWeekend();
        $this->nextWeekDatesWithoutWeekends = fetchNextWeekDatesWithoutWeekend();
        $this->months = fetchMonthWeeks();
    }

    public function render()
    {
        return view('livewire.sale.production2')
            ->extends("layouts.app")
            ->section("contenu2");
    }
}
