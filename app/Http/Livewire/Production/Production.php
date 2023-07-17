<?php

namespace App\Http\Livewire\Production;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;
use App\Models\Objective;
use App\Models\Suspension;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;

class Production extends Component
{

    public $users;
    public $users2;
    public $sales;
    public $sales2;
    public $weekDates;
    public $months;

    public $absence;
    public $absence2;

    public $resignation;
    public $resignation2;

    public $suspension1;
    public $suspension2;

    public $objectiveA;
    public $objectiveB;

    public function mount()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        
        $this->users = User::whereNotExists(function ($query)  use ($currentMonth) {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
        })->where('company', 'lh')
            ->where('group', '1')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();

        $this->users2 = User::whereNotExists(function ($query)  use ($currentMonth) {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
        })->where('company', 'lh')
            ->where('group', '2')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();

        $this->sales = Sale::select('user_id', 'date_confirm')
            ->selectRaw('SUM(quantity) as sales_count')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->whereIn('state', [1, 5, 6, 7, 8])
            ->where('users.group', '1')
            ->groupBy('user_id', 'date_confirm')
            ->get();

        $this->sales2 = Sale::select('user_id', 'date_confirm')
            ->selectRaw('SUM(quantity) as sales_count')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->whereIn('state', [1, 5, 6, 7, 8])
            ->where('users.group', '2')
            ->groupBy('user_id', 'date_confirm')
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

        $this->resignation = Resignation::select('user_id')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.group', '1')
            ->groupBy('user_id')
            ->get();

        $this->resignation2 = Resignation::select('user_id')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.group', '2')
            ->groupBy('user_id')
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
        $this->months = fetchMonthWeeks();
    }

    public function render()
    {

        $this->objectiveA = Objective::where('group', '1')->get();
        $this->objectiveB = Objective::where('group', '2')->get();

        return view('livewire.sale.production', [
            'weekDates' => $this->weekDates,
            'months' => $this->months,
            'objective' => $this->objectiveA,
            'objectiveB' => $this->objectiveB
        ])
            ->extends("layouts.app")
            ->section("contenu2");
    }
}
