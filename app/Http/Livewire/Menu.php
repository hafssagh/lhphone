<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use Livewire\Component;

class Menu extends Component
{
    public function render()
    {
        return view('livewire.menu')
        ->extends("layouts.master");
    }

    
    public function calculSalaryWorkH(){
        $users = User::all();
        $currentMonth = Carbon::now()->format('Y-m');
        foreach ($users as $user) {
            $totalAbsenceDays = Absence::where('user_id', $user->id)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->sum('abs_hours');
            $workHours = calculerHeuresTravail();
            $user->work_hours = $workHours - $totalAbsenceDays;
            $workHoursMonth = calculerHeuresTravailParMois();
            $salary_perHour = $user->base_salary / $workHoursMonth;
            $salary = $salary_perHour * $user->work_hours;
            $user->salary = round($salary, 0, PHP_ROUND_HALF_UP);

            $user->save();
        }

    }
    
}
