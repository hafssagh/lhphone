<?php

namespace App\Http\Livewire\Production;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Absence;
use App\Models\Appoint;
use Livewire\Component;
use App\Models\Objective;
use App\Models\Suspension;
use App\Models\Renovations;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;

class Produit extends Component
{
    public $users;
    public $users2;
    public $users3;

    public $sales;
    public $sales2;
    public $appoint;
    public $renovation1;
    public $renovation2;

    public $weekDates;
    public $weekDatesWithoutWeekends;
    public $nextWeekDatesWithoutWeekends;
    public $months;

    public $absence;
    public $absence2;
    public $absenceh2f;

    public $resignation;
    public $resignation2;
    public $resignationh2f;

    public $suspension1;
    public $suspension2;
    public $suspensionh2f;

    public $objectiveA;
    public $objectiveB;

    public $objectif = "";
    public $objective = "";
    public $editing = null;

    public function mount()
    {
        $currentWeekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
        $currentWeekEnd = Carbon::now()->endOfWeek()->format('Y-m-d');

        $this->users = User::whereNotExists(function ($query) use ($currentWeekStart, $currentWeekEnd) {
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

        $this->users3 = User::whereNotExists(function ($query)  use ($currentWeekStart, $currentWeekEnd) {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
        })->where('company', 'h2f')
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

        $this->appoint = Appoint::select('user_id', 'date_confirm', 'date_prise', 'date_rdv', 'cr', 'state')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
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

        $this->absenceh2f = Absence::select('user_id', 'date', 'abs_hours')
            ->join('users', 'absences.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
            ->groupBy('user_id', 'date', 'abs_hours')
            ->get();

        $this->resignation = Resignation::select('user_id', 'date')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.group', '1')
            ->groupBy('user_id', 'date')
            ->get();

        $this->resignation2 = Resignation::select('user_id', 'date')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.group', '2')
            ->groupBy('user_id', 'date')
            ->get();

        $this->resignationh2f = Resignation::select('user_id', 'date')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
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

        $this->suspensionh2f = Suspension::select('user_id', 'date_debut', 'date_fin')
            ->join('users', 'suspension.user_id', '=', 'users.id')
            ->where('users.company', 'h2f')
            ->groupBy('user_id', 'date_debut', 'date_fin')
            ->get();

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

        $this->weekDates = fetchWeekDates();
        $this->weekDatesWithoutWeekends = fetchWeekDatesWithoutWeekend();
        $this->nextWeekDatesWithoutWeekends = fetchNextWeekDatesWithoutWeekend();
        $this->months = fetchMonthWeeks();
    }

    public function render()
    {
        $this->objectiveA = Objective::where('group', '1')->get();
        $this->objectiveB = Objective::where('group', '2')->get();

        return view('livewire.sale.productionManager', [
            'weekDates' => $this->weekDates,
            'months' => $this->months,
            'objective' => $this->objectiveA,
            'objectiveB' => $this->objectiveB
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function updateObjective($id)
    {
        $this->validate([
            'objectif.' . $id => 'nullable|integer',
        ]);

        $user = User::findOrFail($id);
        $user->objectif = $this->objectif[$id] ?: null;
        $user->save();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Objectif ajouté avec succès!"]);
        return redirect()->to('/production');
    }

    public function update($group)
    {
        $this->validate([
            'objective' => 'nullable|integer',
        ]);

        $obj = Objective::where('group', $group)->first();
        if ($obj) {
            $obj->objective = $this->objective;
            $obj->save();
        }

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Objectif ajouté avec succès!"]);
        return redirect()->to('/production');
    }

    public function updateA()
    {
        return $this->update('1');
    }

    public function updateB()
    {
        return $this->update('2');
    }
}
