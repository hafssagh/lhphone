<?php

namespace App\Http\Livewire\Production;

use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sales extends Component
{
    public $currentPage = PAGELIST;
    public $state;

    public $search = "";

    public $newSale = [];
    public $editSale = [];

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

        $user = Auth::user();

        $sales = Sale::where('user_id', $user->id)->orderBy('date_sal', 'desc')
        ->when($this->search, function ($query, $search) {
            return $query->whereHas('users', function ($query) use ($search) {
                $query->where('name_client', 'like', '%' . $search . '%');
            });
        })
        ->get();

        return view('livewire.sale.index', ["sales" => $sales])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function filterState($state = null)
    {
        $this->state = $state;
    }

    public function goToListeSales()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }

    public function goToaddSale()
    {
        $this->newSale = "";
        $this->currentPage = PAGECREATEFORM;
    }

    public function addNewSale()
    {
        $this->validate();
        $userId = Auth::user()->id;
        $sale = new Sale;
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
        $sale->user_id  = $this->newSale["user"] = $userId;
        $sale->save();

        $this->goToListeSales();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Une nouvelle vente a été ajouté avec succès!"]);
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
