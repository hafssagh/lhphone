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

    protected $rules = [
        'newSale.quantity' => 'required',
        'newSale.name_client' => 'required',
        'newSale.mail_client' => 'required',
        'newSale.phone_client' => 'required',
    ];
    protected $messages = [
        'newSale.quantity.required' => "La quantité est requise.",
        'newSale.name_client.required' => "Le nom de la société est requise.",
        'newSale.mail_client.required' => "L'adresse Email du client est requise.",
        'newSale.phone_client.required' => "Le numéro de téléphone du client est requise.",
    ];

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
            ->latest()->paginate(7);

        $users = User::select('id', 'first_name', 'last_name')->where('company','lh')->whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->get();

        return view('livewire.sale.devis.devisEncours', ["sales" => $sales , "users" => $users])
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

    public function goToaddSale()
    {
        $this->newSale = "";
        $this->currentPage = PAGECREATEFORM;
    }
    
    public function addNewSale()
    {
        $this->validate();
        $sale = new Sale;
        $sale->user_id  = $this->newSale["user"];
        $sale->quantity = $this->newSale["quantity"];
        $sale->state = $this->newSale["state"] = "2";
        $sale->date_sal = $this->newSale["date_sal"] = date('Y-m-d');
        if (array_key_exists('date_confirm', $this->newSale)) {
            $sale->date_confirm = $this->newSale["date_confirm"];
        } else {
            $sale->date_confirm = null;
        }
        $sale->name_client = $this->newSale["name_client"];
        $sale->mail_client = $this->newSale["mail_client"];
        $sale->phone_client = $this->newSale["phone_client"];
        if (array_key_exists('remark', $this->newSale)) {
            $sale->remark = $this->newSale["remark"];
        } else {
            $sale->remark = null;
        }
        
        $sale->save();

        $this->goToListeSales();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Une nouvelle vente a été ajouté avec succès!"]);
    }
}
