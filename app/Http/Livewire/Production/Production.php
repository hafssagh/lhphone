<?php

namespace App\Http\Livewire\Production;


use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;

class Production extends Component
{

    public $users;
    public $sales;
    public $weekDates;

    public function mount()
    { 
        $this->users = User::whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->get();
        
        $this->sales = Sale::select('user_id', 'date_sal')
            ->selectRaw('SUM(quantity) as sales_count')
            ->groupBy('user_id', 'date_sal')
            ->get();

        $this->weekDates = fetchWeekDates();
        
    }
    public function render()
    {
        return view('livewire.sale.production' , [
            'weekDates' => $this->weekDates,
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }

    

}

