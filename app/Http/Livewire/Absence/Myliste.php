<?php

namespace App\Http\Livewire\Absence;

use Carbon\Carbon;
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

        return $totalAbsenceDays + $numberOfHours;
    }
}
