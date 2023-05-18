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


        return view('livewire.absence.myliste',[
            "absencesAuth" => Absence::query()
            ->where("user_id" , '=', $user) 
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->get()
        ])
        ->extends("layouts.master")
        ->section("contenu");
    }
 
    public function sumAbs(){
        $user = auth()->user();
        $currentMonth = Carbon::now()->format('Y-m');
            $totalAbsenceDays = Absence::where('user_id', $user->id)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->sum('abs_hours');
        return $totalAbsenceDays;
        }

}
