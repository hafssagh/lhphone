<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Mails;
use App\Models\Absence;
use Livewire\Component;
use App\Models\Suspension;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $group = 1;
    public $search = "";

    public $chartData;

    public $chart = [];


    public function render()
    {
        $user = Auth::user();
        $manager = $user->last_name;
        $currentMonth = Carbon::now()->format('Y-m');
        $currentToday = Carbon::now()->format('Y-m-d');
        $currentWeekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
        $currentWeekEnd = Carbon::now()->endOfWeek()->format('Y-m-d');

        $usersQuery = User::where("company", "like", "lh")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->whereNotExists(function ($query)  use ($currentMonth)  {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereNot('resignations.date', $currentMonth);
            })
            ->orderBy("users.first_name");


        $usersQuery1 = User::where("company", "like", "lh")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id');
            })
            ->orderBy("group")->orderBy("last_name");



        $users3 = User::where("users.company", "like", "lh")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->where('users.group', $this->group)
            ->leftJoin('sales', 'users.id', '=', 'sales.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.group')
            ->selectSub(function ($query) use ($currentMonth) {
                $query->selectRaw('SUM(sales.quantity)')
                    ->from('sales')
                    ->whereColumn('sales.user_id', 'users.id')
                    ->whereRaw("DATE_FORMAT(sales.date_confirm, '%Y-%m') = ?", [$currentMonth])
                    ->whereIn('sales.state', [1, 5, 6, 7, 8]);
            }, 'total_sales')
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.group')
            ->having('total_sales', '>', 0)
            ->orderBy('total_sales', 'desc')
            ->get();

        $usersWithoutSales = User::where("users.company", "like", "lh")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->whereNotExists(function ($query) use ($currentMonth) {
                $query->select(DB::raw(1))
                    ->from('sales')
                    ->whereColumn('sales.user_id', 'users.id')
                    ->whereRaw("DATE_FORMAT(sales.date_confirm, '%Y-%m') = ?", [$currentMonth]);
            })
            ->whereNotExists(function ($query)  use ($currentWeekStart, $currentWeekEnd)  {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
            })
            ->orderBy('users.id')
            ->paginate(3);

        $usersWithoutSalesCount = User::where("users.company", "like", "lh")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->whereNotExists(function ($query) use ($currentMonth) {
                $query->select(DB::raw(1))
                    ->from('sales')
                    ->whereColumn('sales.user_id', 'users.id')
                    ->whereRaw("DATE_FORMAT(sales.date_confirm, '%Y-%m') = ?", [$currentMonth]);
            })
            ->whereNotExists(function ($query)  use  ($currentWeekStart, $currentWeekEnd) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
            })
            ->orderBy('users.id')
            ->get()->count();

        if ($manager == 'EL MESSIOUI') {
            $usersQuery->where('group', $this->group);
            $usersQuery1;
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $usersQuery->where('group', 1);
        } elseif ($manager == 'Essaid') {
            $usersQuery->where('group', 2);
        }

        $users = $usersQuery->get();
        $users1 = $usersQuery1->get();

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

            $resignation = Resignation::where('user_id', $user->id)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
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

            if ($resignation) {
                $resignationDate = Carbon::parse($resignation->date);

                $date = $currentDate->copy();
                while ($date->format('Y-m') === $currentMonth && $date->gte($resignationDate)) {
                    if (!$date->isWeekend()) {
                        $numberOfHours += 8;
                    }
                    $date->subDay();
                }
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

        foreach ($users1 as $user1) {
            $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
            $propoDayCount = Mails::where('user_id', $user1->id)
                ->whereDate('created_at', $currentDate)
                ->count();
            $user1->propoDayCount = $propoDayCount;
        }
        $sortedUsers = $users1->sortByDesc('propoDayCount');
       
        $sumValues = $this->getSumValues();
        $cards = $this->cards();

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
            [
                "users" => $users, "sortedUsers" => $sortedUsers, "users3" => $users3,
                'sumValues' => $sumValues, 'cards' => $cards,
                "usersWithoutSalesCount" => $usersWithoutSalesCount,
                "usersWithoutSales" => $usersWithoutSales
            ],
            compact('months', 'refusedSales', 'acceptedSales')
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function getSumValues()
    {
        $user = Auth::user();
        $manager = $user->last_name;
        $currentMonth = Carbon::now()->format('Y-m');
        $weekDates = fetchWeekDates();
        $monthDates = fetchMonthDates();

        $usersQuery = User::whereNotExists(function ($query)  use ($currentMonth) {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
        })->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
            $query->where('users.group', 1);
        })->when(($manager == 'Essaid'), function ($query) {
            $query->where('users.group', 2);
        })->get();
        

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
            ->when($manager == 'EL MESSIOUI', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', $this->group));
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
            ->when($manager == 'EL MESSIOUI', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', $this->group));
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
        $currentMonth = Carbon::now()->format('Y-m');

        if ($manager == 'Essaid') {
            $sumEnAtt = Mails::whereRaw('DATE(updated_at) = ?', [$today])->where('state', 1)->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $sumEnCours = Sale::whereDate('updated_at', 'LIKE', $currentMonth . '%')
                ->whereIn('state', [1, 5, 6, 7, 8])->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $propo = Mails::whereRaw('DATE(created_at) = ?', [$today])->whereHas('users', fn ($q) => $q->where('group', 2))->count();
           /*  $propoNon = Mails::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 2))->count(); */
           $devisEnvoye = Sale::whereRaw('DATE(created_at) = ?', [$today])->where('state','3')->whereHas('users', fn ($q) => $q->where('group', 2))->count();
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $sumEnAtt = Mails::whereRaw('DATE(updated_at) = ?', [$today])->where('state', 1)->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $sumEnCours = Sale::whereDate('updated_at', 'LIKE', $currentMonth . '%')
                ->whereIn('state', [1, 5, 6, 7, 8])->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $propo = Mails::whereRaw('DATE(created_at) = ?', [$today])->whereHas('users', fn ($q) => $q->where('group', 1))->count();
           /*  $propoNon = Mails::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 1))->count(); */
           $devisEnvoye = Sale::whereRaw('DATE(created_at) = ?', [$today])->where('state','3')->whereHas('users', fn ($q) => $q->where('group', 1))->count();
        } else {
            $sumEnAtt = Mails::whereRaw('DATE(updated_at) = ?', [$today])->where('state', 1)->count();
            $sumEnCours = Sale::whereDate('updated_at', 'LIKE', $currentMonth . '%')
                ->whereIn('state', [1, 5, 6, 7, 8])->count();
            $propo = Mails::whereRaw('DATE(created_at) = ?', [$today])->count();
            /* $propoNon = Mails::where('state', '0')->count(); */
            $devisEnvoye = Sale::whereRaw('DATE(created_at) = ?', [$today])->where('state','3')->count();
        }

        $propo1 = Mails::whereRaw('DATE(created_at) = ?', [$today])->whereHas('users', fn ($q) => $q->where('group', 1))->count();
        $propo2 = Mails::whereRaw('DATE(created_at) = ?', [$today])->whereHas('users', fn ($q) => $q->where('group', 2))->count();

        $propoMatin = Mails::whereRaw('HOUR(created_at) BETWEEN 9 AND 12')
        ->whereRaw('DATE(created_at) = ?', [$today])
        ->whereHas('users', function ($q) {
            $q->where('group', 1);
        })
        ->count();
        $propoSoir = Mails::whereRaw('HOUR(created_at) BETWEEN 13 AND 19')
        ->whereRaw('DATE(created_at) = ?', [$today])
        ->whereHas('users', function ($q) {
            $q->where('group', 1);
        })
        ->count();

        $propoMatin2 = Mails::whereRaw('HOUR(created_at) BETWEEN 9 AND 12')
        ->whereRaw('DATE(created_at) = ?', [$today])
        ->whereHas('users', function ($q) {
            $q->where('group', 2);
        })
        ->count();
        $propoSoir2 = Mails::whereRaw('HOUR(created_at) BETWEEN 13 AND 19')
        ->whereRaw('DATE(created_at) = ?', [$today])
        ->whereHas('users', function ($q) {
            $q->where('group', 2);
        })
        ->count();

        $confirme1 = Mails::whereRaw('DATE(updated_at) = ?', [$today])->where('state', 1)->whereHas('users', fn ($q) => $q->where('group', 1))->count();
        $confirme2 = Mails::whereRaw('DATE(updated_at) = ?', [$today])->where('state', 1)->whereHas('users', fn ($q) => $q->where('group', 2))->count();

        $devisEnvoye1 = Sale::whereRaw('DATE(created_at) = ?', [$today])->where('state','3')->whereHas('users', fn ($q) => $q->where('group', 1))->count();
        $devisEnvoye2 = Sale::whereRaw('DATE(created_at) = ?', [$today])->where('state','3')->whereHas('users', fn ($q) => $q->where('group', 2))->count();

        $sumRefusé = Sale::where('state', '5')->whereIn('date_confirm', $monthDates)->count();
        $sumAccepté = Sale::where('state', '1')->whereIn('date_confirm', $monthDates)->count();
        $sumS = Sale::where('state',  '2')->orWhere('state',  '3')->whereIn('date_sal', $monthDates)->count();
        return [$sumGrp1, $sumGrp2, $sumEnAtt, $sumEnCours, $sumRefusé, $sumAccepté, $sumS, $propo, $devisEnvoye,
         $propo1, $propo2, $propoMatin, $propoSoir, $propoMatin2, $propoSoir2, $confirme1, $confirme2, $devisEnvoye1, $devisEnvoye2];
    }
}
