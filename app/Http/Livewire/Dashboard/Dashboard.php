<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Mails;
use App\Models\Absence;
use Livewire\Component;
use App\Models\Suspension;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search = "";

    public $chartData;

    public $chart = [];


    public function render()
    {
        $user = Auth::user();
        $manager = $user->last_name;

        $usersQuery = User::where("company", "like", "lh")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->where(function ($query) use ($manager) {
                $query->where("first_name", "like", "%" . $this->search . "%")
                    ->orWhere("last_name", "like", "%" . $this->search . "%");
            })
            ->orderBy("last_name");

        if ($manager == 'EL MESSIOUI') {
            $usersQuery->get();
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $usersQuery->where('group', 1)->get();
        } elseif ($manager == 'Essaid') {
            $usersQuery->where('group', 2)->get();
        }

        $users = $usersQuery->paginate(13);

        $currentMonth = Carbon::now()->format('Y-m');
        $currentDate = Carbon::now();
        $weekDates = fetchWeekDates();
        $monthDates = fetchMonthDates();

        foreach ($users as $user) {
            $totalAbsenceDays = Absence::where('user_id', $user->id)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->sum('abs_hours');

            $suspension = Suspension::where('user_id', $user->id)
                ->where(function ($query) use ($currentMonth) {
                    $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                        ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
                })
                ->first();

            if ($suspension) {
                $dateStart = Carbon::parse($suspension->date_debut);
                $dateEnd = Carbon::parse($suspension->date_fin);

                $numberOfHours = 0;
                $date = $currentDate->copy();

                while ($date->format('Y-m') === $currentMonth && $date->gte($dateStart)) {
                    if (!$date->isWeekend() && $date->lte($dateEnd)) {
                        $numberOfHours += 8;
                    }
                    $date->subDay();
                }
            } else {
                $numberOfHours = 0;
            }

            $user->absenceHours = $totalAbsenceDays + $numberOfHours;

            $sumQuantity = Sale::where('user_id', $user->id)
                ->whereIn('date_confirm', $weekDates)
                ->whereIn('state', [1, 5, 6, 7, 8])
                ->sum('quantity');
            $user->sumQuantity = $sumQuantity;

            $sumQuantity2 = Sale::where('user_id', $user->id)
                ->whereIn('date_confirm', $monthDates)
                ->whereIn('state', [1, 5, 6, 7, 8])
                ->sum('quantity');
            $user->sumQuantity2 = $sumQuantity2;
        }

        $sumValues = $this->getSumValues();
        $cards = $this->cards();

        $this->chartData = [
            'labels' => ['Devis igné', 'Devis envoyé', 'Cmd en attente de livraison'],
            'datasets' => [
                [
                    'data' => [$cards[5], $cards[6], $cards[4]],
                    'backgroundColor' => ['#4650dd', '#9fa8da', '#e0e0e0'],
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
            $acceptedSales = $group->whereIn('state', [1, 5, 6, 7, 8])->sum('quantity');
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
        $user = Auth::user();
        $manager = $user->last_name;

        $weekDates = fetchWeekDates();
        $monthDates = fetchMonthDates();

        $usersQuery = User::query();
        $usersQuery->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
            $query->where('group', 1);
        });
        $usersQuery->when(($manager == 'Essaid'), function ($query) {
            $query->where('group', 2);
        });

        $sumSal = $usersQuery->sum('salary');
        $sumSalFixe = $usersQuery->sum('base_salary');
        $sumChall = $usersQuery->sum('challenge');
        $sumPrime = $usersQuery->sum('prime');

        $sumQuantity = Sale::whereIn('state', [1, 5, 6, 7, 8])
            ->whereIn('date_confirm', $weekDates)
            ->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 1));
            })
            ->when($manager == 'Essaid', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 2));
            })
            ->sum('quantity');

        $sumQuantity2 = Sale::whereIn('state', [1, 5, 6, 7, 8])
            ->whereIn('date_confirm', $monthDates)
            ->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 1));
            })
            ->when($manager == 'Essaid', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 2));
            })
            ->sum('quantity');

        return [$sumSal, $sumSalFixe, $sumChall, $sumPrime, $sumQuantity, $sumQuantity2];
    }

    public function cards()
    {
        $monthDates = fetchMonthDates();
        $sumGrp1 = User::where('group', '1')->count();
        $sumGrp2 = User::where('group', '2')->count();

        $user = Auth::user();
        $manager = $user->last_name;
        $today = date('Y-m-d');

        if ($manager == 'Essaid') {
            $sumEnAtt = Mails::whereRaw('DATE(updated_at) = ?', [$today])->whereIn('state', [1, 5, 6, 7, 8])->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $sumEnCours = Sale::where('state', '3')->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $propo = Mails::whereRaw('DATE(created_at) = ?', [$today])->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $propoNon = Mails::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 2))->count();
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $sumEnAtt = Mails::whereRaw('DATE(updated_at) = ?', [$today])->whereIn('state', [1, 5, 6, 7, 8])->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $sumEnCours = Sale::where('state', '3')->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $propo = Mails::whereRaw('DATE(created_at) = ?', [$today])->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $propoNon = Mails::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 1))->count();
        } else {
            /* $sumEnAtt = Sale::where('state', '2')->count(); */
            $sumEnAtt = Mails::whereRaw('DATE(updated_at) = ?', [$today])->whereIn('state', [1, 5, 6, 7, 8])->count();
            $sumEnCours = Sale::where('state', '3')->count();
            $propo = Mails::whereRaw('DATE(created_at) = ?', [$today])->count();
            $propoNon = Mails::where('state', '0')->count();
        }


        $sumRefusé = Sale::where('state', '5')->whereIn('date_confirm', $monthDates)->count();
        $sumAccepté = Sale::where('state', '1')->whereIn('date_confirm', $monthDates)->count();
        $sumS = Sale::where('state',  '2')->orWhere('state',  '3')->whereIn('date_sal', $monthDates)->count();
        return [$sumGrp1, $sumGrp2, $sumEnAtt, $sumEnCours, $sumRefusé, $sumAccepté, $sumS, $propo, $propoNon];
    }
}
