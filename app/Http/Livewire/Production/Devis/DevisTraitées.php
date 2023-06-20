<?php

namespace App\Http\Livewire\Production\Devis;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $manager = $user->last_name;

        $query = Sale::whereNotIn('state', ['2', '3'])
            ->when($this->state, fn ($q, $state) => $q->where('state', $state))
            ->when($this->search, fn ($q, $search) => $q->whereHas(
                'users',
                fn ($q) =>
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('name_client', 'like', "%$search%")
            ))
            ->orderBy('date_confirm', 'desc');

        if ($this->selectedMonth === null || $this->selectedMonth == "all") {
            if ($manager == 'ELMOURABIT' || $manager == 'By') {
                $sales = $query->whereHas('users', fn ($q) => $q->where('group', 1))->paginate(7);
            } elseif ($manager == 'Essaid') {
                $sales = $query->whereHas('users', fn ($q) => $q->where('group', 2))->paginate(7);
            } else {
                $sales = $query->paginate(7);
            }
        } else {
            $sales = $query->whereMonth('date_confirm', $this->selectedMonth)->paginate(7);
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
