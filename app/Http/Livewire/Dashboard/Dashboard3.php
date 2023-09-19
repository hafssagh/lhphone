<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Conges;
use App\Models\Absence;
use Livewire\Component;
use App\Models\Suspension;
use App\Models\Renovations;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard3 extends Component
{
    public $group = 1;

    public function render()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $manager = $user->last_name;

            $currentMonth = Carbon::now()->format('Y-m');
            $currentWeekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
            $currentWeekEnd = Carbon::now()->endOfWeek()->format('Y-m-d');

            $usersQuery = User::where("company", "like", "lh")
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



            $currentMonth = Carbon::now()->format('Y-m');
            $currentDate = Carbon::now();
            $today = Carbon::now()->format('Y-m-d');
            $monthDates = fetchMonthDates();



            $usersQuery1 = User::where("company", "like", "lh")
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('resignations')
                        ->whereRaw('resignations.user_id = users.id');
                })
                ->orderBy("group")->orderBy("last_name");

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

                $conge = Conges::where('user_id', $user->id)->where('statut', '2')
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

                if ($conge) {
                    $dateStart = Carbon::parse($conge->date_debut);
                    $dateEnd = Carbon::parse($conge->date_fin);

                    $numberHours = 0;
                    $date = $currentDate->copy();

                    while ($currentDate <= $dateEnd) {
                        if ($currentDate->isWeekday()) {
                            $numberHours += 8; // Add 8 hours for each weekday
                        }
                        $currentDate->addDay();
                    }
                } else {
                    $numberHours = 0;
                }

                $user->absenceHours = $totalAbsenceDays + $numberOfHours + $numberHours;

                $sumRDV = Renovations::where('user_id', $user->id)
                    ->where('date_confirm', $today)
                    ->where('state', 1)
                    ->count();
                $user->sumRDV = $sumRDV;

                $sumRDV2 = Renovations::where('user_id', $user->id)
                    ->whereIn('date_confirm', $monthDates)
                    ->where('state', 1)
                    ->count();
                $user->sumRDV2 = $sumRDV2;
            }


            foreach ($users1 as $user1) {
                $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                $appointDayCount = Renovations::where('user_id', $user1->id)
                    ->whereDate('created_at', $currentDate)
                    ->count();
                $user1->appointDayCount = $appointDayCount;
            }
            $sortedUsers = $users1->sortByDesc('appointDayCount');

            $users3 = User::where('users.company', 'like', 'lh')
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


            $usersWithoutAppoints = User::where("users.company", "like", "lh")
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

            $usersWithoutAppointCount = User::where("users.company", "like", "lh")
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

            $appointsData = Renovations::select('date_confirm', 'state')
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


        $dep59 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['59', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep29 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['29', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep22 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['22', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep56 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['56', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep35 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['35', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep44 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['44', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep85 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['85', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep49 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['49', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep53 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['53', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep72 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['72', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep50 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['50', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep14 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['14', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep61 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['61', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep27 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['27', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep76 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['76', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep80 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['80', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep60 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['60', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep62 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['62', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep08 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['08', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep02 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['02', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep17 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['17', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep79 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['79', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep86 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['86', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep16 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['16', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep37 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['37', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep41 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['41', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep28 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['28', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep45 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['45', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep36 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['36', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep18 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['18', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep23 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['23', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep87 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['87', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep19 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['19', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep24 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['24', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep33 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['33', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep40 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['40', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep64 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['64', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep51 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['51', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep10 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['10', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep95 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['95', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep78 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['78', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep91 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['91', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep77 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['77', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep01 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['01', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep89 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['89', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep55 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['55', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep52 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['52', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep54 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['54', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep57 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['57', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep67 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['67', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep88 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['88', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep68 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['68', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep70 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['70', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep21 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['21', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep58 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['58', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep03 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['03', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep63 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['63', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep71 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['71', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep46 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['46', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep82 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['82', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep32 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['32', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep65 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['65', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep47 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['47', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep25 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['25', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep90 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['90', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep39 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['39', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep42 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['42', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep69 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['69', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep1 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['01', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep74 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['74', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep73 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['73', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep38 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['38', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep43 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['43', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep15 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['15', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep31 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['31', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep09 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['09', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep81 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['81', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep12 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['12', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep48 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['48', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep07 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['07', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep66 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['66', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep11 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['11', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep34 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['34', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep30 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['30', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep26 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['26', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep84 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['84', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep13 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['13', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep05 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['05', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep04 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['04', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep06 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['06', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep83 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['83', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep92 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['92', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep75 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['75', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep93 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['93', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep94 = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? AND state = ?', ['94', '1'])->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();


        $dep59All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['59'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep29All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['29'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep22All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['22'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep56All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['56'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep35All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['35'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep44All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['44'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep85All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['85'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep49All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['49'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep53All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['53'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep72All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['72'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep50All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['50'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep14All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['14'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep61All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['61'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep27All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['27'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep76All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['76'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep80All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['80'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep60All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['60'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep62All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['62'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep08All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['08'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep02All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['02'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep17All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['17'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep79All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['79'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep86All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['86'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep16All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['16'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep37All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['37'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep41All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['41'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep28All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['28'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep45All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['45'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep36All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['36'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep18All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['18'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep23All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['23'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep87All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['87'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep19All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['19'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep24All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['24'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep33All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['33'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep40All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['40'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep64All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['64'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep51All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['51'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep10All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['10'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep95All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['95'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep78All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['78'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep91All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['91'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep77All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['77'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep01All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['01'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep89All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['89'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep55All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['55'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep52All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['52'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep54All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['54'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep57All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['57'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep67All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['67'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep88All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['88'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep68All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['68'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep70All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['70'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep21All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['21'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep58All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['58'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep03All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['03'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep63All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['63'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep71All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['71'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep46All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['46'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep82All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['82'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep32All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['32'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep65All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['65'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep47All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['47'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep25All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['25'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep90All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['90'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep39All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['39'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep42All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['42'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep69All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['69'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep1All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['01'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep74All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['74'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep73All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['73'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep38All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['38'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep43All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['43'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep15All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['15'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep31All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['31'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep09All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['09'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep81All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['81'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep12All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['12'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep48All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['48'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep07All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['07'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep66All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['66'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep11All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['11'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep34All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['34'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep30All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['30'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep26All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['26'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep84All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['84'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep13All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['13'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep05All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['05'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep04All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['04'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep06All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['06'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep83All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['83'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep92All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['92'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep75All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['75'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep93All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['93'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep94All = Renovations::whereRaw('SUBSTRING(dep, 1, 2) = ? ', ['94'])->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();

        return view(
            'livewire.dashboard.dashboard3',
            [
                'users' => $users, 'sumValues' => $sumValues, 'cards' => $cards,
                'users1' => $sortedUsers, 'users3' => $users3, 'usersWithoutAppoints' => $usersWithoutAppoints,
                'usersWithoutAppointCount' => $usersWithoutAppointCount, 'acceptedRDV' => $acceptedRDV, 'refusedRDV' => $refusedRDV,
                'months' => $months
            ],
            [
                'dep59' => $dep59, 'dep29' => $dep29, 'dep22' => $dep22, 'dep56' => $dep56, 'dep35' => $dep35, 'dep44' => $dep44, 'dep85' => $dep85, 'dep49' => $dep49, 'dep53' => $dep53,
                'dep72' => $dep72, 'dep50' => $dep50, 'dep14' => $dep14, 'dep61' => $dep61, 'dep27' => $dep27, 'dep76' => $dep76, 'dep80' => $dep80, 'dep62' => $dep62, 'dep08' => $dep08, 'dep02' => $dep02, 'dep60' => $dep60, 'dep17' => $dep17, 'dep79' => $dep79, 'dep86' => $dep86, 'dep16' => $dep16, 'dep37' => $dep37, 'dep41' => $dep41, 'dep28' => $dep28, 'dep45' => $dep45, 'dep36' => $dep36, 'dep18' => $dep18, 'dep23' => $dep23, 'dep87' => $dep87, 'dep19' => $dep19, 'dep24' => $dep24, 'dep33' => $dep33, 'dep40' => $dep40, 'dep64' => $dep64, 'dep51' => $dep51, 'dep10' => $dep10, 'dep95' => $dep95, 'dep78' => $dep78, 'dep91' => $dep91, 'dep77' => $dep77, 'dep01' => $dep01, 'dep89' => $dep89, 'dep55' => $dep55, 'dep52' => $dep52, 'dep54' => $dep54, 'dep57' => $dep57,
                'dep67' => $dep67, 'dep88' => $dep88, 'dep68' => $dep68, 'dep70' => $dep70, 'dep21' => $dep21,
                'dep58' => $dep58, 'dep03' => $dep03, 'dep63' => $dep63, 'dep71' => $dep71, 'dep46' => $dep46,
                'dep82' => $dep82, 'dep32' => $dep32, 'dep65' => $dep65, 'dep47' => $dep47, 'dep25' => $dep25,
                'dep90' => $dep90, 'dep39' => $dep39, 'dep42' => $dep42, 'dep69' => $dep69,  'dep1' => $dep1,
                'dep74' => $dep74, 'dep73' => $dep73,  'dep38' => $dep38, 'dep43' => $dep43, 'dep15' => $dep15,
                'dep31' => $dep31, 'dep09' => $dep09, 'dep81' => $dep81, 'dep12' => $dep12, 'dep48' => $dep48,
                'dep07' => $dep07, 'dep66' => $dep66, 'dep11' => $dep11, 'dep34' => $dep34, 'dep30' => $dep30,
                'dep26' => $dep26, 'dep84' => $dep84, 'dep13' => $dep13, 'dep05' => $dep05, 'dep04' => $dep04,
                'dep06' => $dep06,   'dep83' => $dep83, 'dep92' => $dep92, 'dep75' => $dep75, 'dep93' => $dep93,'dep94' => $dep94,
                'dep59All' => $dep59All, 'dep29All' => $dep29All, 'dep22All' => $dep22All, 'dep56All' => $dep56All, 'dep35All' => $dep35All, 'dep44All' => $dep44All, 'dep85All' => $dep85All, 'dep49All' => $dep49All, 'dep53All' => $dep53All,
                'dep72All' => $dep72All, 'dep50All' => $dep50All, 'dep14All' => $dep14All, 'dep61All' => $dep61All, 'dep27All' => $dep27All, 'dep76All' => $dep76All, 'dep80All' => $dep80All, 'dep62All' => $dep62All, 'dep08All' => $dep08All, 'dep02All' => $dep02All, 'dep60All' => $dep60All, 'dep17All' => $dep17All, 'dep79All' => $dep79All, 'dep86All' => $dep86All, 'dep16All' => $dep16All, 'dep37All' => $dep37All, 'dep41All' => $dep41All, 'dep28All' => $dep28All, 'dep45All' => $dep45All, 'dep36All' => $dep36All, 'dep18All' => $dep18All, 'dep23All' => $dep23All, 'dep87All' => $dep87All, 'dep19All' => $dep19All, 'dep24All' => $dep24All, 'dep33All' => $dep33All, 'dep40All' => $dep40All, 'dep64All' => $dep64All, 'dep51All' => $dep51All, 'dep10All' => $dep10All, 'dep95All' => $dep95All, 'dep78All' => $dep78All, 'dep91All' => $dep91All, 'dep77All' => $dep77All, 'dep01All' => $dep01All, 'dep89All' => $dep89All, 'dep55All' => $dep55All, 'dep52All' => $dep52All, 'dep54All' => $dep54All, 'dep57All' => $dep57All,
                'dep67All' => $dep67All, 'dep88All' => $dep88All, 'dep68All' => $dep68All, 'dep70All' => $dep70All, 'dep21All' => $dep21All,
                'dep58All' => $dep58All, 'dep03All' => $dep03All, 'dep63All' => $dep63All, 'dep71All' => $dep71All, 'dep46All' => $dep46All,
                'dep82All' => $dep82All, 'dep32All' => $dep32All, 'dep65All' => $dep65All, 'dep47All' => $dep47All, 'dep25All' => $dep25All,
                'dep90All' => $dep90All, 'dep39All' => $dep39All, 'dep42All' => $dep42All, 'dep69All' => $dep69All,  'dep1All' => $dep1All,
                'dep74All' => $dep74All, 'dep73All' => $dep73All,  'dep38All' => $dep38All, 'dep43All' => $dep43All, 'dep15All' => $dep15All,
                'dep31All' => $dep31All, 'dep09All' => $dep09All, 'dep81All' => $dep81All, 'dep12All' => $dep12All, 'dep48All' => $dep48All,
                'dep07All' => $dep07All, 'dep66All' => $dep66All, 'dep11All' => $dep11All, 'dep34All' => $dep34All, 'dep30All' => $dep30All,
                'dep26All' => $dep26All, 'dep84All' => $dep84All, 'dep13All' => $dep13All, 'dep05All' => $dep05All, 'dep04All' => $dep04All,
                'dep06All' => $dep06All,   'dep83All' => $dep83All,'dep92All' => $dep92All, 'dep75All' => $dep75All, 'dep93All' => $dep93All,'dep94All' => $dep94All,
            ],
            
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function getSumValues()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $today = Carbon::now()->format('Y-m-d');
        $monthDates = fetchMonthDates();
        $user = Auth::user();
        $manager = $user->last_name;

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


        $allRDV = Renovations::where('date_confirm', $today)
            ->where('state', 1)
            ->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 1));
            })
            ->when($manager == 'Essaid', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 2));
            })
            ->when($manager == 'EL MESSIOUI', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', $this->group));
            })
            ->count();

        $allRDV2 = Renovations::whereIn('date_confirm', $monthDates)
            ->where('state', 1)
            ->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 1));
            })
            ->when($manager == 'Essaid', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', 2));
            })
            ->when($manager == 'EL MESSIOUI', function ($query) {
                $query->whereHas('users', fn ($q) => $q->where('group', $this->group));
            })
            ->count();

        return [$sumSal, $sumSalFixe, $sumChall, $sumPrime, $allRDV, $allRDV2];
    }

    public function cards()
    {
        $today = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $manager = $user->last_name;

        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $allRDV = Renovations::whereDate('created_at', $today)->whereNot('state','rapp')->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $confirme = Renovations::whereDate('date_confirm', $today)->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $enAttente = Renovations::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 1))->count();;
            $rappel = Renovations::where('state', 'rapp')->whereHas('users', fn ($q) => $q->where('group', 1))->count();
        } elseif ($manager == 'Essaid') {
            $allRDV = Renovations::whereDate('created_at', $today)->whereNot('state','rapp')->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $confirme = Renovations::whereDate('date_confirm', $today)->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $enAttente = Renovations::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 2))->count();;
            $rappel = Renovations::where('state', 'rapp')->whereHas('users', fn ($q) => $q->where('group', 2))->count();
        } else {
            $allRDV = Renovations::whereDate('created_at', $today)->whereNot('state','rapp')->count();
            $confirme = Renovations::whereDate('date_confirm', $today)->count();
            $enAttente = Renovations::where('state', '0')->count();;
            $rappel = Renovations::where('state', 'rapp')->count();
        }
        return [$allRDV, $confirme, $enAttente, $rappel];
    }
}
