<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuivieH extends Component
{
    public function render()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $user = Auth::user();

        $users = User::where("users.company", "like", "h2f")
        ->whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })
        ->whereExists(function ($query) use ($currentMonth) {
            $query->select(DB::raw(1))
                ->from('appointments')
                ->whereColumn('appointments.user_id', 'users.id')
                ->whereRaw("DATE_FORMAT(appointments.created_at, '%Y-%m') = ?", [$currentMonth]);
        })
        ->leftJoin('appointments', 'users.id', '=', 'appointments.user_id')
        ->select('users.id', 'users.first_name', 'users.last_name', 'users.group')
        ->selectRaw('COUNT(CASE WHEN appointments.state = 1 THEN 1 ELSE NULL END) AS propo_count1')
        ->selectRaw('COUNT(appointments.id) AS propo_count')
        ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.group')
        ->orderBy('first_name', 'asc');

        $users = $users->get();
        
        $monthWeeks = fetchMonthWeeks();
        $weeklyPropo = [];

        foreach ($monthWeeks as $week) {
            $startOfWeek = $week['start'];
            $endOfWeek = $week['end'];
            $weekPropo = [];

            foreach ($users as $user) {
                $userId = $user->id;

                $propo = DB::table('appointments')
                    ->where('user_id', $userId)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->count();

                $propoAccept = DB::table('appointments')
                    ->where('user_id', $userId)
                    ->whereBetween('date_confirm', [$startOfWeek, $endOfWeek])
                    ->where('state', 1)
                    ->count();

                $weekPropo[] = [
                    'name' => $user->first_name,
                    'propo' => $propo,
                    'propoAccept' => $propoAccept,
                ];
            }

            $weeklyPropo[] = [
                'week' => $week,
                'data' => $weekPropo,
            ];
        }
        
        return view('livewire.dashboard.suivie-h', compact('weeklyPropo'), ["users" => $users])->extends("layouts.master")
        ->section("contenu");
    }
}
