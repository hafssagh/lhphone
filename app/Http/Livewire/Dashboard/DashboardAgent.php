<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Mails;
use App\Models\Absence;
use App\Models\Objective;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardAgent extends Component
{
    public function render()
    {
        $cards = $this->cards();
        $quantitySoldPerWeek = $this->getQuantitySoldPerWeek();
        $objectif = $this->objectif();

        return view(
            'livewire.dashboard.dashboard-agent',
            ['cards' => $cards, 'quantitySoldPerWeek' => $quantitySoldPerWeek, 'objectif' => $objectif]
        )
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function cards()
    {
        $user = Auth::user();
        $today = date('Y-m-d');
        $currentMonth = Carbon::now()->format('Y-m');
        $weekDates = fetchWeekDates();
        $monthDates = fetchMonthDates();

        $sumQuantity = Sale::where('user_id', $user->id)->whereIn('state', [1, 5, 6, 7, 8])
            ->whereIn('date_confirm', $weekDates)
            ->sum('quantity');

        $sumQuantity2 = Sale::where('user_id', $user->id)->whereIn('state', [1, 5, 6, 7, 8])
            ->whereIn('date_confirm', $monthDates)
            ->sum('quantity');

        $challenge = User::where('id', $user->id)->select('challenge')->get();
        $prime = User::where('id', $user->id)->select('prime')->get();

        $propo = Mails::where('user_id', $user->id)->whereRaw('DATE(created_at) = ?', [$today])->count();
        $confirmé = Mails::where('user_id', $user->id)->whereRaw('DATE(updated_at) = ?', [$today])->where('state', 1)->count();
        $devisSigné = Sale::where('user_id', $user->id)->whereDate('updated_at', 'LIKE', $currentMonth . '%')
            ->whereIn('state', [1, 5, 6, 7, 8])->count();
        $absence = Absence::where('user_id', $user->id)->whereDate('created_at', 'LIKE', $currentMonth . '%')->count();

        return [$propo, $confirmé, $devisSigné, $absence, $sumQuantity, $sumQuantity2, $challenge, $prime];
    }

    public function objectif()
    {
        $user = Auth::user();
        $objectives = User:: pluck('objectif');
    
        return $objectives;
    }

    function MonthWeeks()
    {
        $monthWeeks = [];
        $currentDate = Carbon::now()->startOfMonth();

        for ($weekCount = 1; $weekCount <= 4; $weekCount++) {
            $weekStart = $currentDate->copy()->startOfWeek();
            $weekEnd = $currentDate->copy()->endOfWeek();

            $monthWeeks[] = [
                'start' => $weekStart->toDate(),
                'end' => $weekEnd->toDate(),
            ];

            $currentDate->addWeek();
        }

        return $monthWeeks;
    }

    function getQuantitySoldPerWeek()
    {
        $user = Auth::user();

        $monthWeeks = $this->MonthWeeks();
        $quantitySoldPerWeek = [];

        foreach ($monthWeeks as $week) {
            $startOfWeek = $week['start'];
            $endOfWeek = $week['end'];

            $quantitySold = DB::table('sales')
                ->where('user_id', $user->id)
                ->whereBetween('date_confirm', [$startOfWeek, $endOfWeek])
                ->whereIn('state', [1, 5, 6, 7, 8])
                ->sum('quantity');

            $quantitySoldPerWeek[] = $quantitySold;
        }

        return $quantitySoldPerWeek;
    }

 

}
