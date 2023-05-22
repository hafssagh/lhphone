<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Absence;
use Livewire\Component;

class Myliste extends Component
{

    public function render()
    {
        Carbon::setLocale("fr");

        $currentMonth = Carbon::now()->format('Y-m');

        $user = auth()->user()->id;

        $absence = Absence::query()
            ->where("user_id", '=', $user)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->get();
        $allAbsence = Absence::query()
            ->where("user_id", '=', $user)
            ->get();

        return view('livewire.absence.myliste', [
            "absencesAuth" => $absence , "absencesAll" => $allAbsence
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function sumAbs()
    {
        $user = auth()->user();
        $currentMonth = Carbon::now()->format('Y-m');
        $totalAbsenceDays = Absence::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->sum('abs_hours');
        return $totalAbsenceDays;
    }

    public function workHours()
    {
        $workHours = calculerHeuresTravail();
        $totalAbsenceDays = $this->sumAbs();

        $work_hours = $workHours - $totalAbsenceDays;
        return $work_hours;
    }
}
