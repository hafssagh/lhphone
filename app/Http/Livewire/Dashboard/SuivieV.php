<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuivieV extends Component
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
                    ->from('sales')
                    ->whereColumn('sales.user_id', 'users.id')
                    ->whereRaw("DATE_FORMAT(sales.date_confirm, '%Y-%m') = ?", [$currentMonth]);
            })
            ->leftJoin('sales', 'users.id', '=', 'sales.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.group')
            ->selectRaw('COUNT(CASE WHEN sales.state IN (6, 7, 8) THEN 1 ELSE NULL END) AS sale_count')
            ->selectRaw('COUNT(CASE WHEN sales.state = 5 THEN 1 ELSE NULL END) AS sale_count2')
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.group')
            ->orderBy('first_name', 'asc')
            ->get();
        
    
            if ($manager == 'EL MESSIOUI') {
                $users->where('users.group', [1,2]);
            } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
                $users->where('users.group', 1);
            } elseif ($manager == 'Essaid') {
                $users->where('users.group', 2);
            }
    
            $monthWeeks = fetchMonthWeeks();

            $weeklySales = [];
    
            foreach ($monthWeeks as $week) {
                $startOfWeek = $week['start'];
                $endOfWeek = $week['end'];
                $weekSales = [];
    
                foreach ($users as $user) {
                    $userId = $user->id;
    
                    $sales = DB::table('sales')
                        ->where('user_id', $userId)
                        ->whereBetween('date_confirm', [$startOfWeek, $endOfWeek])
                        ->whereIn('state', [6,7,8])
                        ->count();
    
                    $sales2 = DB::table('sales')
                        ->where('user_id', $userId)
                        ->whereBetween('date_confirm', [$startOfWeek, $endOfWeek])
                        ->where('state', 5)
                        ->count();
    
                    $weekSales[] = [
                        'name' => $user->first_name,
                        'sales' => $sales,
                        'sales2' => $sales2,
                    ];
                }
    
                $weeklySales[] = [
                    'week' => $week,
                    'data' => $weekSales,
                ];
            }
    
            return view('livewire.dashboard.suivie-v', compact('weeklySales'), ["users" => $users])->extends("layouts.master")
                ->section("contenu");
        
    }
}