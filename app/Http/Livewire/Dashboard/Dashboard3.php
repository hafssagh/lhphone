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


        $dep59All = Renovations::where('dep', 'REGEXP', '^59')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep29All = Renovations::where('dep', 'REGEXP', '^29')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep22All = Renovations::where('dep', 'REGEXP', '^22')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep56All = Renovations::where('dep', 'REGEXP', '^56')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep35All = Renovations::where('dep', 'REGEXP', '^35')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep44All = Renovations::where('dep', 'REGEXP', '^44')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep85All = Renovations::where('dep', 'REGEXP', '^85')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep49All = Renovations::where('dep', 'REGEXP', '^49')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep53All = Renovations::where('dep', 'REGEXP', '^53')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep72All = Renovations::where('dep', 'REGEXP', '^72')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep50All = Renovations::where('dep', 'REGEXP', '^50')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep14All = Renovations::where('dep', 'REGEXP', '^14')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep61All = Renovations::where('dep', 'REGEXP', '^61')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep27All = Renovations::where('dep', 'REGEXP', '^27')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep76All = Renovations::where('dep', 'REGEXP', '^76')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep80All = Renovations::where('dep', 'REGEXP', '^80')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep60All = Renovations::where('dep', 'REGEXP', '^60')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep62All = Renovations::where('dep', 'REGEXP', '^62')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep08All = Renovations::where('dep', 'REGEXP', '^08')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep02All = Renovations::where('dep', 'REGEXP', '^02')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep17All = Renovations::where('dep', 'REGEXP', '^17')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep79All = Renovations::where('dep', 'REGEXP', '^79')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep86All = Renovations::where('dep', 'REGEXP', '^86')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep16All = Renovations::where('dep', 'REGEXP', '^16')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep37All = Renovations::where('dep', 'REGEXP', '^37')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep41All = Renovations::where('dep', 'REGEXP', '^41')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep28All = Renovations::where('dep', 'REGEXP', '^28')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep45All = Renovations::where('dep', 'REGEXP', '^45')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep36All = Renovations::where('dep', 'REGEXP', '^36')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep18All = Renovations::where('dep', 'REGEXP', '^18')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep23All = Renovations::where('dep', 'REGEXP', '^23')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep87All = Renovations::where('dep', 'REGEXP', '^87')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep19All = Renovations::where('dep', 'REGEXP', '^19')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep24All = Renovations::where('dep', 'REGEXP', '^24')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep33All = Renovations::where('dep', 'REGEXP', '^33')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep40All = Renovations::where('dep', 'REGEXP', '^33')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep64All = Renovations::where('dep', 'REGEXP', '^64')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep51All = Renovations::where('dep', 'REGEXP', '^51')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep10All = Renovations::where('dep', 'REGEXP', '^10')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep95All = Renovations::where('dep', 'REGEXP', '^10')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep78All = Renovations::where('dep', 'REGEXP', '^78')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep91All = Renovations::where('dep', 'REGEXP', '^91')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep77All = Renovations::where('dep', 'REGEXP', '^77')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep01All = Renovations::where('dep', '01')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep89All = Renovations::where('dep', 'REGEXP', '^89')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep55All = Renovations::where('dep', 'REGEXP', '^55')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep52All = Renovations::where('dep', 'REGEXP', '^52')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep54All = Renovations::where('dep', 'REGEXP', '^54')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep57All = Renovations::where('dep', 'REGEXP', '^57')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep67All = Renovations::where('dep', 'REGEXP', '^67')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep88All = Renovations::where('dep', 'REGEXP', '^88')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep68All = Renovations::where('dep', 'REGEXP', '^68')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep70All = Renovations::where('dep', 'REGEXP', '^70')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep21All = Renovations::where('dep', 'REGEXP', '^21')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep58All = Renovations::where('dep', 'REGEXP', '^58')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep03All = Renovations::where('dep', 'REGEXP', '^03')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep63All = Renovations::where('dep', 'REGEXP', '^63')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep71All = Renovations::where('dep', 'REGEXP', '^71')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep46All = Renovations::where('dep', 'REGEXP', '^46')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep82All = Renovations::where('dep', 'REGEXP', '^82')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep32All = Renovations::where('dep', 'REGEXP', '^32')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep65All = Renovations::where('dep', 'REGEXP', '^65')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep47All = Renovations::where('dep', 'REGEXP', '^47')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep25All = Renovations::where('dep', 'REGEXP', '^25')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep90All = Renovations::where('dep', 'REGEXP', '^90')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep39All = Renovations::where('dep', 'REGEXP', '^39')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep42All = Renovations::where('dep', 'REGEXP', '^42')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep69All = Renovations::where('dep', 'REGEXP', '^69')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep1All = Renovations::where('dep', '01')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep74All = Renovations::where('dep', 'REGEXP', '^74')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep73All = Renovations::where('dep', 'REGEXP', '^73')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep38All = Renovations::where('dep', 'REGEXP', '^38')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep43All = Renovations::where('dep', 'REGEXP', '43')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep15All = Renovations::where('dep', 'REGEXP', '15')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep31All = Renovations::where('dep', 'REGEXP', '31')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep09All = Renovations::where('dep', 'REGEXP', '09')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep81All = Renovations::where('dep', 'REGEXP', '81')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep12All = Renovations::where('dep', 'REGEXP', '12')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep48All = Renovations::where('dep', 'REGEXP', '48')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep07All = Renovations::where('dep', 'REGEXP', '07')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep66All = Renovations::where('dep', 'REGEXP', '66')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep11All = Renovations::where('dep', 'REGEXP', '11')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep34All = Renovations::where('dep', 'REGEXP', '34')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep30All = Renovations::where('dep', 'REGEXP', '30')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep26All = Renovations::where('dep', 'REGEXP', '26')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep84All = Renovations::where('dep', 'REGEXP', '84')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep13All = Renovations::where('dep', 'REGEXP', '13')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep05All = Renovations::where('dep', 'REGEXP', '05')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep04All = Renovations::where('dep', 'REGEXP', '04')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep06All = Renovations::where('dep', 'REGEXP', '06')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep83All = Renovations::where('dep', 'REGEXP', '83')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep92All = Renovations::where('dep', 'REGEXP', '92')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep75All = Renovations::where('dep', 'REGEXP', '75')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep93All = Renovations::where('dep', 'REGEXP', '93')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep94All = Renovations::where('dep', 'REGEXP', '94')->whereNot('state','rapp')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();

        $dep59 = Renovations::where('dep', 'REGEXP', '^59')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep29 = Renovations::where('dep', 'REGEXP', '^29')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep22 = Renovations::where('dep', 'REGEXP', '^22')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep56 = Renovations::where('dep', 'REGEXP', '^56')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep35 = Renovations::where('dep', 'REGEXP', '^35')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep44 = Renovations::where('dep', 'REGEXP', '^44')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep85 = Renovations::where('dep', 'REGEXP', '^85')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep49 = Renovations::where('dep', 'REGEXP', '^49')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep53 = Renovations::where('dep', 'REGEXP', '^53')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep72 = Renovations::where('dep', 'REGEXP', '^72')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep50 = Renovations::where('dep', 'REGEXP', '^50')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep14 = Renovations::where('dep', 'REGEXP', '^14')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep61 = Renovations::where('dep', 'REGEXP', '^61')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep27 = Renovations::where('dep', 'REGEXP', '^27')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep76 = Renovations::where('dep', 'REGEXP', '^76')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep80 = Renovations::where('dep', 'REGEXP', '^80')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep60 = Renovations::where('dep', 'REGEXP', '^60')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep62 = Renovations::where('dep', 'REGEXP', '^62')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep08 = Renovations::where('dep', 'REGEXP', '^08')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep02 = Renovations::where('dep', 'REGEXP', '^02')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep17 = Renovations::where('dep', 'REGEXP', '^17')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep79 = Renovations::where('dep', 'REGEXP', '^79')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep86 = Renovations::where('dep', 'REGEXP', '^86')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep16 = Renovations::where('dep', 'REGEXP', '^16')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep37 = Renovations::where('dep', 'REGEXP', '^37')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep41 = Renovations::where('dep', 'REGEXP', '^41')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep28 = Renovations::where('dep', 'REGEXP', '^28')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep45 = Renovations::where('dep', 'REGEXP', '^45')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep36 = Renovations::where('dep', 'REGEXP', '^36')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep18 = Renovations::where('dep', 'REGEXP', '^18')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep23 = Renovations::where('dep', 'REGEXP', '^23')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep87 = Renovations::where('dep', 'REGEXP', '^87')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep19 = Renovations::where('dep', 'REGEXP', '^19')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep24 = Renovations::where('dep', 'REGEXP', '^24')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep33 = Renovations::where('dep', 'REGEXP', '^33')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep40 = Renovations::where('dep', 'REGEXP', '^33')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep64 = Renovations::where('dep', 'REGEXP', '^64')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep51 = Renovations::where('dep', 'REGEXP', '^51')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep10 = Renovations::where('dep', 'REGEXP', '^10')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep95 = Renovations::where('dep', 'REGEXP', '^10')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep78 = Renovations::where('dep', 'REGEXP', '^78')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep91 = Renovations::where('dep', 'REGEXP', '^91')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep77 = Renovations::where('dep', 'REGEXP', '^77')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep01 = Renovations::where('dep', '01')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep89 = Renovations::where('dep', 'REGEXP', '^89')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep55 = Renovations::where('dep', 'REGEXP', '^55')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep52 = Renovations::where('dep', 'REGEXP', '^52')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep54 = Renovations::where('dep', 'REGEXP', '^54')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep57 = Renovations::where('dep', 'REGEXP', '^57')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep67 = Renovations::where('dep', 'REGEXP', '^67')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep88 = Renovations::where('dep', 'REGEXP', '^88')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep68 = Renovations::where('dep', 'REGEXP', '^68')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep70 = Renovations::where('dep', 'REGEXP', '^70')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep21 = Renovations::where('dep', 'REGEXP', '^21')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep58 = Renovations::where('dep', 'REGEXP', '^58')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep03 = Renovations::where('dep', 'REGEXP', '^03')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep63 = Renovations::where('dep', 'REGEXP', '^63')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep71 = Renovations::where('dep', 'REGEXP', '^71')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep46 = Renovations::where('dep', 'REGEXP', '^46')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep82 = Renovations::where('dep', 'REGEXP', '^82')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep32 = Renovations::where('dep', 'REGEXP', '^32')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep65 = Renovations::where('dep', 'REGEXP', '^65')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep47 = Renovations::where('dep', 'REGEXP', '^47')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep25 = Renovations::where('dep', 'REGEXP', '^25')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep90 = Renovations::where('dep', 'REGEXP', '^90')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep39 = Renovations::where('dep', 'REGEXP', '^39')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep42 = Renovations::where('dep', 'REGEXP', '^42')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep69 = Renovations::where('dep', 'REGEXP', '^69')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep1 = Renovations::where('dep', '01')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep74 = Renovations::where('dep', 'REGEXP', '^74')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep73 = Renovations::where('dep', 'REGEXP', '^73')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep38 = Renovations::where('dep', 'REGEXP', '^38')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep43 = Renovations::where('dep', 'REGEXP', '43')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep15 = Renovations::where('dep', 'REGEXP', '15')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep31 = Renovations::where('dep', 'REGEXP', '31')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep09 = Renovations::where('dep', 'REGEXP', '09')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep81 = Renovations::where('dep', 'REGEXP', '81')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep12 = Renovations::where('dep', 'REGEXP', '12')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep48 = Renovations::where('dep', 'REGEXP', '48')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep07 = Renovations::where('dep', 'REGEXP', '07')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep66 = Renovations::where('dep', 'REGEXP', '66')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep11 = Renovations::where('dep', 'REGEXP', '11')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep34 = Renovations::where('dep', 'REGEXP', '34')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep30 = Renovations::where('dep', 'REGEXP', '30')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep26 = Renovations::where('dep', 'REGEXP', '26')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep84 = Renovations::where('dep', 'REGEXP', '84')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep13 = Renovations::where('dep', 'REGEXP', '13')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep05 = Renovations::where('dep', 'REGEXP', '05')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep04 = Renovations::where('dep', 'REGEXP', '04')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep06 = Renovations::where('dep', 'REGEXP', '06')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep83 = Renovations::where('dep', 'REGEXP', '83')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep92 = Renovations::where('dep', 'REGEXP', '92')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep75 = Renovations::where('dep', 'REGEXP', '75')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep93 = Renovations::where('dep', 'REGEXP', '93')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();
        $dep94 = Renovations::where('dep', 'REGEXP', '94')->where('state', '1')->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 1));})->when($manager == 'Essaid', function ($query) { $query->whereHas('users', fn ($q) => $q->where('group', 2));})->count();

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
                'dep72All' => $dep72All, 'dep50All' => $dep50All, 'dep14All' => $dep14All, 'dep61All' => $dep61All, 'dep27All' => $dep27All, 'dep76All' => $dep76All, 'dep80All' => $dep80All, 'dep62All' => $dep62All, 'dep08All' => $dep08All, 'dep02All' => $dep02All, 'dep60All' => $dep60All, 'dep17All' => $dep17All, 'dep79All' => $dep79All, 'dep86All' => $dep86All, 'dep16All' => $dep16All, 'dep37All' => $dep37All, 'dep41All' => $dep41All, 'dep28All' => $dep28All, 'dep45All' => $dep45All, 'dep36All' => $dep36All, 'dep18All' => $dep18All, 'dep23All' => $dep23All, 'dep87All' => $dep87All, 'dep19All' => $dep19All, 'dep24All' => $dep24All, 'dep33All' => $dep33All, 'dep40All' => $dep40All, 'dep64All' => $dep64All, 'dep51All' => $dep51All, 'dep10All' => $dep10All, 'dep95All' => $dep95All, 'dep78All' => $dep78All, 'dep91All' => $dep91All, 'dep77All' => $dep77All, 'dep01All' => $dep01All, 'dep89All' => $dep89All, 'dep55All' => $dep55All, 'dep52All' => $dep52All, 'dep54All' => $dep54, 'dep57All' => $dep57All,
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
            $allRDV = Renovations::whereDate('created_at', $today)->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $confirme = Renovations::whereDate('date_confirm', $today)->whereHas('users', fn ($q) => $q->where('group', 1))->count();
            $enAttente = Renovations::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 1))->count();;
            $rappel = Renovations::where('state', 'rapp')->whereHas('users', fn ($q) => $q->where('group', 1))->count();
        } elseif ($manager == 'Essaid') {
            $allRDV = Renovations::whereDate('created_at', $today)->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $confirme = Renovations::whereDate('date_confirm', $today)->whereHas('users', fn ($q) => $q->where('group', 2))->count();
            $enAttente = Renovations::where('state', '0')->whereHas('users', fn ($q) => $q->where('group', 2))->count();;
            $rappel = Renovations::where('state', 'rapp')->whereHas('users', fn ($q) => $q->where('group', 2))->count();
        } else {
            $allRDV = Renovations::whereDate('created_at', $today)->count();
            $confirme = Renovations::whereDate('date_confirm', $today)->count();
            $enAttente = Renovations::where('state', '0')->count();;
            $rappel = Renovations::where('state', 'rapp')->count();
        }
        return [$allRDV, $confirme, $enAttente, $rappel];
    }
}
