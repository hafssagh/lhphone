<?php

namespace App\Http\Livewire\Production\Devis;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DevisEnCours extends Component
{
    public $state;

    public $search = "";

    public $newSale = [];
    public $editSale = [];

    public $currentPage = PAGEDEVIS;
 
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function render()
    {
        $sales = Sale::orderBy('date_sal', 'desc')
            ->whereNot('state', '1')
            ->whereNot('state', '-1')
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
            ->paginate(5);

        return view('livewire.sale.devis.devisEncours', ["sales" => $sales])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function filterState($state = null)
    {
        $this->state = $state;
    }

    public function saleValide($id)
    {
        $this->editSale = Sale::with("users")->find($id)->toArray();
        $sale = Sale::find($this->editSale["id"]);
        $sale->state = $this->editSale["state"] = "1";
        $sale->date_confirm = $this->newSale["date_confirm"] =  date('Y-m-d');
        $sale->save();
        CalculChallenge();
        CalculPrime();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Devis a été accepté!"]);
    }

    public function saleRefuse($id)
    {

        $this->editSale = Sale::with("users")->find($id)->toArray();
        $sale = Sale::find($this->editSale["id"]);
        $sale->state = $this->editSale["state"] = "-1";
        $sale->date_confirm = $this->newSale["date_confirm"] =  date('Y-m-d');
        $sale->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Devis a été refusé!"]);
    }

    public function saleSend($id)
    {

        $this->editSale = Sale::with("users")->find($id)->toArray();
        $sale = Sale::find($this->editSale["id"]);
        $sale->state = $this->editSale["state"] = "3";
        $sale->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Devis envoyé!"]);
    }

    public function goToListeSales()
    {
        $this->resetValidation();
        $this->currentPage = PAGEDEVIS;
    }

    public function editSale($id)
    {
        $this->editSale = Sale::with("users")->find($id)->toArray();
        $this->currentPage = PAGEEDITFORM; 
    }

    public function updateSale()
    {
        $sale = Sale::find($this->editSale["id"]);
        $sale->fill($this->editSale);
        $sale->save();
        $this->goToListeSales();
        $this->dispatchBrowserEvent("showSuccessMessage");
    }

}
