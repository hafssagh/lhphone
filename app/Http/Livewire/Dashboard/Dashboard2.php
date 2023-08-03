<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use App\Models\Appoint;
use Livewire\Component;
use App\Models\Suspension;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard2 extends Component
{
    public function render()
    {
        if (auth()->check()) {
            $user = Auth::user();

            $currentMonth = Carbon::now()->format('Y-m');
            $currentWeekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
            $currentWeekEnd = Carbon::now()->endOfWeek()->format('Y-m-d');

            $usersQuery = User::where("company", "like", "h2f")
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })
                ->whereNotExists(function ($query)  use ($currentMonth) {
                    $query->select(DB::raw(1))
                        ->from('resignations')
                        ->whereRaw('resignations.user_id = users.id')
                        ->whereNot('resignations.date', $currentMonth);
                })
                ->orderBy("users.first_name");

            $users = $usersQuery->get();


            $currentMonth = Carbon::now()->format('Y-m');
            $currentDate = Carbon::now();
            $today = Carbon::now()->format('Y-m-d');
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

                $sumRDV = Appoint::where('user_id', $user->id)
                    ->where('date_confirm', $today)
                    ->where('state', 1)
                    ->count();
                $user->sumRDV = $sumRDV;

                $sumRDV2 = Appoint::where('user_id', $user->id)
                    ->whereIn('date_confirm', $monthDates)
                    ->where('state', 1)
                    ->count();
                $user->sumRDV2 = $sumRDV2;
            }

            $usersQuery1 = User::where("company", "like", "h2f")
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('resignations')
                        ->whereRaw('resignations.user_id = users.id');
                })
                ->orderBy("group")->orderBy("last_name");

            $users1 = $usersQuery1->get();

            foreach ($users1 as $user1) {
                $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                $appointDayCount = Appoint::where('user_id', $user1->id)
                    ->whereDate('created_at', $currentDate)
                    ->count();
                $user1->appointDayCount = $appointDayCount;
            }
            $sortedUsers = $users1->sortByDesc('appointDayCount');

            $users3 = User::where('users.company', 'like', 'h2f')
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })
                ->leftJoin('appointments', 'users.id', '=', 'appointments.user_id')
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.group')
                ->selectSub(function ($query) use ($currentMonth) {
                    $query->from('appointments')
                        ->whereColumn('appointments.user_id', 'users.id')
                        ->whereRaw("DATE_FORMAT(appointments.date_confirm, '%Y-%m') = ?", [$currentMonth])
                        ->where('appointments.state', 1)
                        ->selectRaw('COUNT(*)');
                }, 'confirme')
                ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.group')
                ->having('confirme', '>', 0)
                ->orderBy('confirme', 'desc')
                ->get();


            $usersWithoutAppoints = User::where("users.company", "like", "h2f")
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })
                ->whereNotExists(function ($query) use ($currentMonth) {
                    $query->select(DB::raw(1))
                        ->from('appointments')
                        ->whereColumn('appointments.user_id', 'users.id')
                        ->whereRaw("DATE_FORMAT(appointments.date_confirm, '%Y-%m') = ?", [$currentMonth]);
                })
                ->whereNotExists(function ($query)  use ($currentWeekStart, $currentWeekEnd) {
                    $query->select(DB::raw(1))
                        ->from('resignations')
                        ->whereRaw('resignations.user_id = users.id')
                        ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
                })
                ->orderBy('users.id')
                ->paginate(3);

            $usersWithoutAppointCount = User::where("users.company", "like", "h2f")
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })
                ->whereNotExists(function ($query) use ($currentMonth) {
                    $query->select(DB::raw(1))
                        ->from('appointments')
                        ->whereColumn('appointments.user_id', 'users.id')
                        ->whereRaw("DATE_FORMAT(appointments.date_confirm, '%Y-%m') = ?", [$currentMonth]);
                })
                ->whereNotExists(function ($query)  use ($currentWeekStart, $currentWeekEnd) {
                    $query->select(DB::raw(1))
                        ->from('resignations')
                        ->whereRaw('resignations.user_id = users.id')
                        ->whereNotBetween('resignations.date', [$currentWeekStart, $currentWeekEnd]);
                })
                ->orderBy('users.id')
                ->get()->count();

            $sumValues = $this->getSumValues();
            $cards = $this->cards();

            $appointsData = Appoint::select('date_confirm', 'state')
                ->orderBy('date_confirm')
                ->get();

            $monthlyData = $appointsData->groupBy(function ($appoint) {
                return Carbon::parse($appoint->date_confirm)->format('M');
            })->map(function ($group) {
                $refusedRDV = $group->whereIn('state', [-1, -2, -3])->count();
                $acceptedRDV = $group->where('state', 1)->count();
                return [
                    'refusedRDV' => $refusedRDV,
                    'acceptedRDV' => $acceptedRDV,
                ];
            });

            $monthlyData = $monthlyData->sortBy(function ($item, $key) {
                return Carbon::parse($key)->month;
            });

            $months = $monthlyData->keys()->toArray();
            $refusedRDV = $monthlyData->pluck('refusedRDV')->toArray();
            $acceptedRDV = $monthlyData->pluck('acceptedRDV')->toArray();
        } else {
            return redirect()->route('login');
        }


        return view('livewire.dashboard.dashboard2', [
            'users' => $users, 'sumValues' => $sumValues, 'cards' => $cards,
            'users1' => $sortedUsers, 'users3' => $users3, 'usersWithoutAppoints' => $usersWithoutAppoints,
            'usersWithoutAppointCount' => $usersWithoutAppointCount, 'acceptedRDV' => $acceptedRDV, 'refusedRDV' => $refusedRDV,
            'months' => $months
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function getSumValues()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $today = Carbon::now()->format('Y-m-d');
        $monthDates = fetchMonthDates();

        $usersQuery = User::where('company', 'h2f')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->whereNotExists(function ($query)  use ($currentMonth) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
            })->get();


        $sumSal = $usersQuery->sum('salary');
        $sumSalFixe = $usersQuery->sum('base_salary');
        $sumChall = $usersQuery->sum('challenge');
        $sumPrime = $usersQuery->sum('prime');


        $allRDV = Appoint::where('date_confirm', $today)
            ->where('state', 1)
            ->count();

        $allRDV2 = Appoint::whereIn('date_confirm', $monthDates)
            ->where('state', 1)
            ->count();

        return [$sumSal, $sumSalFixe, $sumChall, $sumPrime, $allRDV, $allRDV2];
    }

    public function cards()
    {
        $today = Carbon::now()->format('Y-m-d');

        $allRDV = Appoint::whereDate('date_confirm', $today)->count();
        $confirme = Appoint::whereDate('date_confirm', $today)->where('state', 1)->count();
        $enAttente = Appoint::where('state', 0)->count();
        $rappel = Appoint::whereIn('state', [3, 4])->count();


        return [$allRDV, $confirme, $enAttente, $rappel];
    }
}
