<?php

namespace App\Http\Livewire\Production\Devis;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class DevisTraitées extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $state;

    public $search = "";
    public $selectedMonth;

    public $newSale = [];
    public $editSale = [];

    public function render()
    {
        if ($this->selectedMonth === null || $this->selectedMonth == "all") {
            $sales = Sale::whereNot('state', '2')
                ->whereNot('state', '3')
                ->when($this->state, function ($query, $state) {
                    return $query->where('state', $state);
                })
                ->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('name_client', 'like', '%' . $search . '%');
                    });
                })
                ->orderBy('date_confirm', 'desc')->paginate(7);
        } else {
            $sales = Sale::whereMonth('date_confirm', $this->selectedMonth)
                ->whereNot('state', '2')
                ->whereNot('state', '3')
                ->when($this->state, function ($query, $state) {
                    return $query->where('state', $state);
                })
                ->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('name_client', 'like', '%' . $search . '%');
                    });
                })
                ->orderBy('date_confirm', 'desc')->paginate(7);
        }

        return view('livewire.sale.devis.devisTraitées', ["sales" => $sales])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function filterState($state = null)
    {
        $this->state = $state;
    }
}
