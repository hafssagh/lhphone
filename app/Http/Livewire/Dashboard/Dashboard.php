<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public function render()
    {
        $users = User::where("company", "like", "lh")
            ->where("company", "NOT LIKE", "h2f")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->where(function ($query) {
                $query->where("first_name", "like", "%" . $this->search . "%")
                    ->orWhere("last_name", "like", "%" . $this->search . "%");
            })
            ->orderBy("last_name")
            ->get();

        $currentMonth = Carbon::now()->format('Y-m');
        $weekDates = fetchWeekDates();
        $monthDates = fetchMonthDates();

        foreach ($users as $user) {
            $totalAbsenceDays = Absence::where('user_id', $user->id)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->sum('abs_hours');
            $user->totalAbsenceDays = $totalAbsenceDays;

            $sumQuantity = Sale::where('user_id', $user->id)
                ->whereIn('date_confirm', $weekDates)
                ->where('state', '1')
                ->sum('quantity');
            $user->sumQuantity = $sumQuantity;

            $sumQuantity2 = Sale::where('user_id', $user->id)
                ->whereIn('date_confirm', $monthDates)
                ->where('state', '1')
                ->sum('quantity');
            $user->sumQuantity2 = $sumQuantity2;
        }

        $sumValues = $this->getSumValues();
        $cards = $this->cards();

        return view('livewire.dashboard.dashboard', ["users" => $users , 'sumValues' => $sumValues , 'cards' => $cards])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function getSumValues(){
        $weekDates = fetchWeekDates();
        $monthDates = fetchMonthDates();

        $sumSal = User :: sum('salary');
        $sumSalFixe = User :: sum('base_salary');
        $sumChall = User :: sum('challenge');
        $sumPrime = User :: sum('prime');
        $sumQuantity = Sale::whereIn('date_confirm', $weekDates)
        ->where('state', '1')
        ->sum('quantity');
        $sumQuantity2 = Sale::whereIn('date_confirm', $monthDates)
        ->where('state', '1')
        ->sum('quantity');
        return [$sumSal,$sumSalFixe,$sumChall,$sumPrime,$sumQuantity,$sumQuantity2];
    }

    public function cards(){
        $sumGrp1 = User::where('group', '1')->count();
        $sumGrp2 = User::where('group', '2')->count();
        $sumEnAtt = Sale::where('state', '3')->count();
        $sumEnCours = Sale::where('state', '2')->count();
        return [$sumGrp1,$sumGrp2,$sumEnAtt,$sumEnCours];
    }
  
}
