<?php

namespace App\Http\Livewire\Production;


use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;

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

    public function mount()
    {
        $this->users = User::where('company', 'lh')
            ->where('group', '1')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();

        $this->users2 = User::where('company', 'lh')
            ->where('group', '2')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();

        $this->sales = Sale::select('user_id', 'date_confirm')
            ->selectRaw('SUM(quantity) as sales_count')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->where('state', '1')
            ->where('users.group', '1')
            ->groupBy('user_id', 'date_confirm')
            ->get();

        $this->sales2 = Sale::select('user_id', 'date_confirm')
            ->selectRaw('SUM(quantity) as sales_count')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->where('state', '1')
            ->where('users.group', '2')
            ->groupBy('user_id', 'date_confirm')
            ->get();

        $this->absence = Absence::select('user_id', 'date')
            ->join('users', 'absences.user_id', '=', 'users.id')
            ->where('users.group', '1')
            ->groupBy('user_id', 'date')
            ->get();

        $this->absence2 = Absence::select('user_id', 'date')
            ->join('users', 'absences.user_id', '=', 'users.id')
            ->where('users.group', '2')
            ->groupBy('user_id', 'date')
            ->get();


        $this->weekDates = fetchWeekDates();
        $this->months = fetchMonthWeeks();
    }
    public function render()
    {
        return view('livewire.sale.production', [
            'weekDates' => $this->weekDates,
            'months' => $this->months,
        ])
            ->extends("layouts.app")
            ->section("contenu2");
    }
}
