<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Conges;
use App\Models\Absence;
use Livewire\Component;
use App\Models\Suspension;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;

class DashRH extends Component
{

    public $group = 1;

    public function render()
    {
        Carbon::setLocale("fr");
        if (auth()->check()) {
            $currentDate = Carbon::now();
            $currentMonth = Carbon::now()->format('Y-m');

            $usersQuery = User::whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->where(function ($query) {
                $query->where('group', $this->group);
            })->whereNotExists(function ($query) use ($currentMonth) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
            });

            $users = $usersQuery->orderBy('last_name')->get();

            $userCardre = User::whereHas('roles', function ($query) {
                $query->where('name', 'manager');
            })->orderBy('last_name')->get();

            $userInfo = User::whereHas('roles', function ($query) {
                $query->where('name', 'Administrateur');
            })->orderBy('last_name')->get();

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

                $conge = Conges::where('user_id', $user->id)->where('statut', '2')
                    ->where(function ($query) use ($currentMonth) {
                        $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                            ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
                    })
                    ->get();

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

                $numberHours = 0;

                foreach ($conge as $congeItem) {
                    $dateStart = Carbon::parse($congeItem->getAttribute('date_debut'));
                    $dateEnd = Carbon::parse($congeItem->getAttribute('date_fin'));

                    $currentDate = $dateStart->copy();

                    while ($currentDate <= $dateEnd) {
                        if ($currentDate->isWeekday()) {
                            $numberHours += 8;
                        }
                        $currentDate->addDay();
                    }
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
                $user->absenceHours = $totalAbsenceDays + $numberOfHours + $numberHours;
            }

            foreach ($userCardre as $userCadre) {
                $totalAbsenceDays = Absence::where('user_id', $userCadre->id)
                    ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                    ->sum('abs_hours');

                $suspension = Suspension::where('user_id', $userCadre->id)
                    ->where(function ($query) use ($currentMonth) {
                        $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                            ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
                    })
                    ->first();

                $conge = Conges::where('user_id', $userCadre->id)->where('statut', '2')
                    ->where(function ($query) use ($currentMonth) {
                        $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                            ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
                    })
                    ->get();

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

                $numberHours = 0;

                foreach ($conge as $congeItem) {
                    $dateStart = Carbon::parse($congeItem->getAttribute('date_debut'));
                    $dateEnd = Carbon::parse($congeItem->getAttribute('date_fin'));

                    $currentDate = $dateStart->copy();

                    while ($currentDate <= $dateEnd) {
                        if ($currentDate->isWeekday()) {
                            $numberHours += 8;
                        }
                        $currentDate->addDay();
                    }
                }

                $userCadre->absenceHours = $totalAbsenceDays + $numberOfHours + $numberHours;
            }
            
            foreach ($userInfo as $userI) {
                $totalAbsenceDays = Absence::where('user_id', $userI->id)
                    ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                    ->sum('abs_hours');

                $suspension = Suspension::where('user_id', $userI->id)
                    ->where(function ($query) use ($currentMonth) {
                        $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                            ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
                    })
                    ->first();

                $conge = Conges::where('user_id', $userI->id)->where('statut', '2')
                    ->where(function ($query) use ($currentMonth) {
                        $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                            ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
                    })
                    ->get();

                $resignation = Resignation::where('user_id', $userI->id)
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

                $numberHours = 0;

                foreach ($conge as $congeItem) {
                    $dateStart = Carbon::parse($congeItem->getAttribute('date_debut'));
                    $dateEnd = Carbon::parse($congeItem->getAttribute('date_fin'));

                    $currentDate = $dateStart->copy();

                    while ($currentDate <= $dateEnd) {
                        if ($currentDate->isWeekday()) {
                            $numberHours += 8;
                        }
                        $currentDate->addDay();
                    }
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
                $userI->absenceHours = $totalAbsenceDays + $numberOfHours + $numberHours;
            }

            $userGet = User::select('first_name', 'last_name', 'photo', 'birthday')
                ->whereRaw("DATE_FORMAT(birthday, '%m-%d') = ?", [$currentDate->format('m-d')])
                ->get();


            $currentDay = Carbon::now()->format('Y-m-d');

            $stagiaire = User::query()->where('type_contract', 'sans')->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->whereNotExists(function ($query)  use ($currentDay) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereNot('resignations.date', $currentDay);
            })
                ->orderBy('company')->latest()->get();

            $cards = $this->cards();
            $absence = $this->absence();
        } else {
            return redirect()->route('login');
        }


        return view(
            'livewire.dashboard.dashRH',
            [
                'users' => $users, 'userCardre' => $userCardre, 'userInfo' => $userInfo,
                'cards' => $cards, 'userGet' => $userGet,
                'stagiaire' => $stagiaire, 'absence' => $absence
            ]
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function cards()
    {
        $currentDate = Carbon::now();

        $userCount = User::leftJoin('resignations', 'users.id', '=', 'resignations.user_id')
            ->whereNull('resignations.user_id')
            ->count();
        $userslh1 = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->where('group', 1)->count();
        $userslh2 = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->where('group', 2)->count();
        $usersh2f = User::query()->where('company', 'h2f')->count();
        $currentWeek = Carbon::now()->subWeek(); // Subtracting a week to get the starting date of the last week
        $currentDay = Carbon::now();

        $newEmploye = User::whereBetween('created_at', [
            $currentWeek->format('Y-m-d'),
            $currentDay->format('Y-m-d')
        ])->count();
        $depart = Resignation::query()->count();
        $absence = Absence::query()->whereRaw("DATE_FORMAT(date, '%Y-%m-%d') = ?", [$currentDate->format('Y-m-d')])->count();
        $birthday = User::leftJoin('resignations', 'users.id', '=', 'resignations.user_id')
            ->whereNull('resignations.user_id')
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') = ?", [$currentDate->format('m-d')])
            ->count();

        return [$userCount, $userslh1, $userslh2, $usersh2f, $newEmploye, $depart, $absence, $birthday];
    }

    public function absence()
    {
        $jan = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 1)->count();
        $fev = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 2)->count();
        $mars = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 3)->count();
        $avr = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 4)->count();
        $mai = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 5)->count();
        $juin = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 6)->count();
        $juil = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 7)->count();
        $aout = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 8)->count();
        $sept = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 9)->count();
        $oct = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 10)->count();
        $nov = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 11)->count();
        $dec = Absence::query()->whereRaw("DATE_FORMAT(date, '%m') = ?", 12)->count();

        return [$jan, $fev, $mars, $avr, $mai, $juin, $juil, $aout, $sept, $oct, $nov, $dec];
    }
}
