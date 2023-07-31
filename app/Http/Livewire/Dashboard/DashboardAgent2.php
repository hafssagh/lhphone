<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use App\Models\Appoint;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardAgent2 extends Component
{
    public function render()
    {
        $cards = $this->cards();
        $CountRDV = $this->getCountRDV();

        $user = Auth::user();

         $rdvData = Appoint::where('user_id', $user->id)->select('date_confirm', 'state')
            ->orderBy('date_confirm')
            ->get();

        $monthlyData = $rdvData->groupBy(function ($appoint) {
            return Carbon::parse($appoint->date_confirm)->format('M');
        })->map(function ($group) {
            $refusedAppoints = $group->whereIn('state', [-1, -3, -3])->count();
            $acceptedAppoints = $group->where('state', 1)->count();
            return [
                'refusedAppoints' => $refusedAppoints,
                'acceptedAppoints' => $acceptedAppoints,
            ];
        });

        $monthlyData = $monthlyData->sortBy(function ($item, $key) {
            return Carbon::parse($key)->month;
        });

        $months = $monthlyData->keys()->toArray();
        $refusedAppoints = $monthlyData->pluck('refusedAppoints')->toArray();
        $acceptedAppoints = $monthlyData->pluck('acceptedAppoints')->toArray(); 

        return view('livewire.dashboard.dashboard-agent2' , ['cards' => $cards , 'CountRDV' => $CountRDV] , 
        compact('months', 'refusedAppoints', 'acceptedAppoints'))
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

        $countRdv = Appoint::where('user_id', $user->id)->where('date_prise', $today) ->count();
        $countConf = Appoint::where('user_id', $user->id)->where('state', 1)->where('date_confirm', $today) ->count();
        $countEnCours= Appoint::where('user_id', $user->id)->where('state', 0)  ->count();
        $absence = Absence::where('user_id', $user->id)->whereDate('created_at', 'LIKE', $currentMonth . '%')->count();
     
        $sumRdvWeek = Appoint::where('user_id', $user->id)->where('state', 1)
        ->whereIn('date_confirm', $weekDates)
        ->count();
        $sumRdvMon = Appoint::where('user_id', $user->id)->where('state', 1)
        ->whereIn('date_confirm', $monthDates)
        ->count();

        $challenge = User::where('id', $user->id)->select('challenge')->get();
        $prime = User::where('id', $user->id)->select('prime')->get();

        return [$countRdv , $countConf , $countEnCours , $absence , $sumRdvWeek , $sumRdvMon , $challenge , $prime];
    }

    function getCountRDV()
    {
        $user = Auth::user();

        $monthWeeks = fetchMonthWeeks();
        $countRDV = [];

        foreach ($monthWeeks as $week) {
            $startOfWeek = $week['start'];
            $endOfWeek = $week['end'];

            $quantitySold = DB::table('appointments')
                ->where('user_id', $user->id)
                ->whereBetween('date_confirm', [$startOfWeek, $endOfWeek])
                ->where('state', 1)
                ->count();

            $countRDV[] = $quantitySold;
        }

        return $countRDV;
    }
}
