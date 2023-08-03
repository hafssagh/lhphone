<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Livewire\Production\Sales;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Mails;
use App\Models\Absence;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardAgent extends Component
{
    public function render()
    {
        if (auth()->check()) {
            $cards = $this->cards();
            $quantitySoldPerWeek = $this->getQuantitySoldPerWeek();
            $objectif = $this->objectif();

            $user = Auth::user();

            $salesData = Sale::where('user_id', $user->id)->select('date_confirm', 'quantity', 'state')
                ->orderBy('date_confirm')
                ->get();

            $monthlyData = $salesData->groupBy(function ($sale) {
                return Carbon::parse($sale->date_confirm)->format('M');
            })->map(function ($group) {
                $refusedSales = $group->where('state', '-1')->sum('quantity');
                $acceptedSales = $group->whereIn('state', [1, 5, 6, 7, 8])->sum('quantity');
                return [
                    'refusedSales' => $refusedSales,
                    'acceptedSales' => $acceptedSales,
                ];
            });

            $monthlyData = $monthlyData->sortBy(function ($item, $key) {
                return Carbon::parse($key)->month;
            });


            $months = $monthlyData->keys()->toArray();
            $refusedSales = $monthlyData->pluck('refusedSales')->toArray();
            $acceptedSales = $monthlyData->pluck('acceptedSales')->toArray();


            $devisData = Sale::where('user_id', $user->id)->select('date_confirm', 'state')
                ->orderBy('date_confirm')
                ->get();

                $propoData = Mails::where('user_id', $user->id)
                ->select('created_at', 'state')
                ->orderBy('created_at')
                ->get();
            
            // Fetch data for proposals based on updated_at column.
            $propoData2 = Mails::where('user_id', $user->id)
                ->select('updated_at', 'state')
                ->orderBy('updated_at')
                ->get();
            
            // Group $propoData by month and count the number of proposals sent for each month.
            $monthlyPropo = $propoData->groupBy(function ($propo) {
                return Carbon::parse($propo->created_at)->format('M');
            })->map(function ($group) {
                $propoEnvoye = $group->count();
                return [
                    'propoEnvoye' => $propoEnvoye,
                ];
            });
            
            // Group $propoData2 by month and count the number of proposals confirmed for each month.
            $monthlyPropo2 = $propoData2->groupBy(function ($propo) {
                return Carbon::parse($propo->updated_at)->format('M');
            })->map(function ($group) {
                $propoConfirme = $group->where('state', 1)->count();
                return [
                    'propoConfirme' => $propoConfirme,
                ];
            });

            $monthlyDevis = $devisData->groupBy(function ($devis) {
                return Carbon::parse($devis->date_confirm)->format('M');
            })->map(function ($group) {
                $devisSigne = $group->whereIn('state', [1, 5, 6, 7, 8])->count();
                return [
                    'devisSigne' => $devisSigne,
                ];
            });

            $monthlyDevis = $monthlyDevis->sortBy(function ($item, $key) {
                return Carbon::parse($key)->month;
            });

            $monthlyPropo = $monthlyPropo->sortBy(function ($item, $key) {
                return Carbon::parse($key)->month;
            });

            $monthlyPropo2 = $monthlyPropo2->sortBy(function ($item, $key) {
                return Carbon::parse($key)->month;
            });

            $mergedData = $monthlyPropo->merge($monthlyDevis);
            $mergedData = $monthlyPropo2->merge($monthlyDevis);
            $months1 = $mergedData->keys()->toArray();
            $propoEnvoye = $monthlyPropo->pluck('propoEnvoye')->toArray();
            $propoConfirme = $monthlyPropo2->pluck('propoConfirme')->toArray();
            $devisSigne = $mergedData->pluck('devisSigne')->toArray();
        } else {
            return redirect()->route('login');
        }

        return view(
            'livewire.dashboard.dashboard-agent',
            ['cards' => $cards, 'quantitySoldPerWeek' => $quantitySoldPerWeek, 'objectif' => $objectif],
            compact('months', 'refusedSales', 'acceptedSales', 'months1', 'propoEnvoye', 'propoConfirme', 'devisSigne')
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
        $objectives = User::pluck('objectif');

        return $objectives;
    }

    function getQuantitySoldPerWeek()
    {
        $user = Auth::user();

        $monthWeeks = fetchMonthWeeks();
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
