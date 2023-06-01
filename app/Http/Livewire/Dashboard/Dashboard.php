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

    public $chartData;

    public $chart = [];


    public function render()
    {
        $users = User::where("company", "like", "lh")
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

        $this->chartData = [
            'labels' => ['Accepté', 'Non traité', 'Refusé'],
            'datasets' => [
                [
                    'data' => [$cards[5], $cards[6], $cards[4]],
                    'backgroundColor' => ['#35b653', '#835db4', '#dc3545'],
                ],
            ],
        ];

        $salesData = Sale::select('date_confirm', 'quantity', 'state')
            ->orderBy('date_confirm')
            ->get();

        $monthlyData = $salesData->groupBy(function ($sale) {
            return Carbon::parse($sale->date_confirm)->format('M');
        })->map(function ($group) {
            $refusedSales = $group->where('state', '-1')->sum('quantity');
            $acceptedSales = $group->where('state', '1')->sum('quantity');
            return [
                'refusedSales' => $refusedSales,
                'acceptedSales' => $acceptedSales,
            ];
        });

        $monthlyData = $monthlyData->sortBy(function ($item, $key) {
            return Carbon::parse($key)->month;
        });

        $months = $monthlyData->keys()->toArray();
        $refusedSales = $monthlyData->pluck('refusedSales')->toArray();
        $acceptedSales = $monthlyData->pluck('acceptedSales')->toArray();

        return view(
            'livewire.dashboard.dashboard',
            ["users" => $users, 'sumValues' => $sumValues, 'cards' => $cards],
            compact('months', 'refusedSales', 'acceptedSales')
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function getSumValues()
    {
        $weekDates = fetchWeekDates();
        $monthDates = fetchMonthDates();

        $sumSal = User::sum('salary');
        $sumSalFixe = User::sum('base_salary');
        $sumChall = User::sum('challenge');
        $sumPrime = User::sum('prime');
        $sumQuantity = Sale::whereIn('date_confirm', $weekDates)
            ->where('state', '1')
            ->sum('quantity');
        $sumQuantity2 = Sale::whereIn('date_confirm', $monthDates)
            ->where('state', '1')
            ->sum('quantity');
        return [$sumSal, $sumSalFixe, $sumChall, $sumPrime, $sumQuantity, $sumQuantity2];
    }

    public function cards()
    {
        $monthDates = fetchMonthDates();
        $sumGrp1 = User::where('group', '1')->count();
        $sumGrp2 = User::where('group', '2')->count();
        $sumEnAtt = Sale::where('state', '2')->count();
        $sumEnCours = Sale::where('state', '3')->count();
        $sumRefusé = Sale::where('state', '-1')->whereIn('date_confirm', $monthDates)->count();
        $sumAccepté = Sale::where('state', '1')->whereIn('date_confirm', $monthDates)->count();
        $sumS = Sale::where('state',  '2')->orWhere('state',  '3')->whereIn('date_sal', $monthDates)->count();
        return [$sumGrp1, $sumGrp2, $sumEnAtt, $sumEnCours, $sumRefusé, $sumAccepté, $sumS];
    }
}

