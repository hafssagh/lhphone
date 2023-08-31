<?php

namespace App\Http\Livewire\Absence;

use Carbon\Carbon;
use App\Models\Conges;
use App\Models\Absence;
use Livewire\Component;
use App\Models\Suspension;

class Myliste extends Component
{

    public function render()
    {
        Carbon::setLocale("fr");

        if (auth()->check()) {
            $currentDay = Carbon::now()->format('Y-m-d');
            $currentMonth = Carbon::now()->format('Y-m');

            $user = auth()->user()->id;

            $absence = Absence::query()
                ->where("user_id", '=', $user)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m-%d') = ?", [$currentDay])
                ->get();

            $allAbsence = Absence::query()
                ->where("user_id", '=', $user)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->whereRaw("DATE_FORMAT(date, '%Y-%m-%d') <> ?", [$currentDay])
                ->get();

            $suspension = Suspension::query()
                ->where('user_id', '=', $user)
                ->where(function ($query) use ($currentMonth) {
                    $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                        ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
                })
                ->get();
        } else {
            return redirect()->route('login');
        }


        return view('livewire.absence.myliste', [
            "absencesAuth" => $absence, "absencesAll" => $allAbsence, "suspension" => $suspension
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function sumAbs()
    {
        $user = auth()->user();
        $currentMonth = Carbon::now()->format('Y-m');
        $currentDate = Carbon::now();
        $totalAbsenceDays = Absence::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->whereRaw("abs_hours > ?", [0])
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


        return $totalAbsenceDays + $numberOfHours + $numberHours;
    }
}
