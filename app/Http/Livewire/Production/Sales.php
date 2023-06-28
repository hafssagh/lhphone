<?php

namespace App\Http\Livewire\Production;

use App\Models\Sale;
use App\Models\Mails;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
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
        'newSale.name_client' => 'required|unique:sales,name_client',
    ];
    protected $messages = [
        'newSale.quantity.required' => "La quantité est requise.",
        'newSale.name_client.required' => "Le nom de la société est requise.", 
        'newSale.name_client.unique' => "Le nom de la société doit être unique.",
    ];

    public function render()
    {
        $user = Auth::user();

        DB::statement('SET sql_mode=(SELECT REPLACE(@@sql_mode, "ONLY_FULL_GROUP_BY", ""));');
        
        $sales = Sale::select('sales.*')
            ->join('mails', 'mails.user_id', '=', 'sales.user_id')
            ->where('sales.user_id', $user->id)
            ->orderBy('sales.date_sal', 'desc')
            ->groupBy('sales.id')
            ->when($this->search, function ($query, $search) {
                return $query->whereHas('users', function ($query) use ($search) {
                    $query->where('sales.name_client', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(7);
    
        $selectedUserId = $user->id;
        $mailsQuery = Mails::where('user_id', $selectedUserId)->where('state','1') ->latest()->get();
    
        return view('livewire.sale.index', ["sales" => $sales, 'mails' => $mailsQuery])
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
        $mails = Mails::where('company', $this->newSale["name_client"])->first();
        $userId = Auth::user()->id;
        $sale = new Sale;
        $sale->quantity = $this->newSale["quantity"];
        $sale->state = $this->newSale["state"] = "2";
        $sale->date_sal = $this->newSale["date_sal"] = date('Y-m-d');
        $sale->date_confirm = $this->newSale["date_confirm"] ?? null;
        $sale->name_client = $this->newSale["name_client"];
        $sale->mail_client = $mails->emailClient ?? null;
        $sale->phone_client = $mails->numClient ?? null;
        $sale->un = $this->newSale["un"] ?? null;
        $sale->deux = $this->newSale["deux"] ?? null;
        $sale->trois = $this->newSale["trois"] ?? null;
        $sale->cinq = $this->newSale["cinq"] ?? null;
        $sale->dix = $this->newSale["dix"] ?? null;
        $sale->hublots = $this->newSale["hublots"] ?? null;
        $sale->reglette = $this->newSale["reglette"] ?? null;
        $sale->pommeaux = $this->newSale["pommeaux"] ?? null;
        $sale->mousseurs = $this->newSale["mousseurs"] ?? null;
        $sale->tube = $this->newSale["tube"] ?? null;
        $sale->spot = $this->newSale["spot"] ?? null;
        $sale->remark = $this->newSale["remark"] ?? null;
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
