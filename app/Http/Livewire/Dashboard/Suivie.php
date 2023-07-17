<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Suivie extends Component
{

    public function render()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $user = Auth::user();
        $manager = $user->last_name;

        $users = User::where("users.company", "like", "lh")
        ->whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })
        ->whereExists(function ($query) use ($currentMonth) {
            $query->select(DB::raw(1))
                ->from('mails')
                ->whereColumn('mails.user_id', 'users.id')
                ->whereRaw("DATE_FORMAT(mails.created_at, '%Y-%m') = ?", [$currentMonth]);
        })
        ->leftJoin('mails', 'users.id', '=', 'mails.user_id')
        ->select('users.id', 'users.first_name', 'users.last_name', 'users.group')
        ->selectRaw('COUNT(CASE WHEN mails.state IN (0, 1, 3, -1) THEN 1 ELSE NULL END) AS mail_count')
        ->selectRaw('COUNT(CASE WHEN mails.state = 1 THEN 1 ELSE NULL END) AS mail_count2')
        ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.group')
        ->orderBy('first_name', 'asc');
    

        if ($manager == 'EL MESSIOUI') {
            $users;
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $users->where('users.group', 1);
        } elseif ($manager == 'Essaid') {
            $users->where('users.group', 2);
        }

        $users = $users->get();
        
        $monthWeeks = fetchMonthWeeks();
        $weeklyPropo = [];

        foreach ($monthWeeks as $week) {
            $startOfWeek = $week['start'];
            $endOfWeek = $week['end'];
            $weekPropo = [];

            foreach ($users as $user) {
                $userId = $user->id;

                $propo = DB::table('mails')
                    ->where('user_id', $userId)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->whereIn('state', [1,0,-1,3])
                    ->count();

                $propoAccept = DB::table('mails')
                    ->where('user_id', $userId)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
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

        return view('livewire.dashboard.suivie', compact('weeklyPropo'), ["users" => $users])->extends("layouts.master")
            ->section("contenu");
    }
}
