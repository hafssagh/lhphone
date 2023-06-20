<?php

namespace App\Http\Livewire\Production\Devis;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class DevisEnCours extends Component
{
    public $state;

    public $search = "";

    public $newSale = [];
    public $editSale = [];

    public $selectedId;

    public $currentPage = PAGEDEVIS;

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $rules = [
        'newSale.user' => 'required',
        'newSale.quantity' => 'required',
        'newSale.name_client' => 'required',
        'newSale.mail_client' => 'required',
        'newSale.phone_client' => 'required',
    ];
    protected $messages = [
        'newSale.user.required' => "Le nom complet de l'agent est requis.",
        'newSale.quantity.required' => "La quantité est requise.",
        'newSale.name_client.required' => "Le nom de la société est requise.",
        'newSale.mail_client.required' => "L'adresse Email du client est requise.",
        'newSale.phone_client.required' => "Le numéro de téléphone du client est requise.",
    ];

    public function render()
    {
        $user = Auth::user();
        $manager = $user->last_name;

        $query = Sale::orderBy('date_sal', 'desc')
            ->whereNotIn('state', ['1', '-1'])
            ->when($this->state, fn ($q, $state) => $q->where('state', $state))
            ->when($this->search, fn ($q, $search) => $q->whereHas(
                'users',
                fn ($q) =>
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('name_client', 'like', "%$search%")
            ));

        $usersQuery = User::select('id', 'first_name', 'last_name')
            ->where('company', 'lh')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            });

        if ($manager == 'EL MESSIOUI') {
            $users = $usersQuery->get();
            $sales = $query->latest()->paginate(7);
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $users = $usersQuery->where('group', 1)->get();
            $sales = $query->whereHas('users', fn ($q) => $q->where('group', 1))
                ->latest()
                ->paginate(7);
        } elseif ($manager == 'Essaid') {
            $users = $usersQuery->where('group', 2)->get();
            $sales = $query->whereHas('users', fn ($q) => $q->where('group', 2))
                ->latest()
                ->paginate(7);
        }
        
        return view('livewire.sale.devis.devisEncours', ["sales" => $sales, "users" => $users])
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
        $sale->date_confirm = $this->newSale["date_confirm"] ?? null;
        $sale->name_client = $this->newSale["name_client"];
        $sale->mail_client = $this->newSale["mail_client"];
        $sale->phone_client = $this->newSale["phone_client"];
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

        $sale->save();

        $this->goToListeSales();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Une nouvelle vente a été ajoutée avec succès!"]);
    }


    public function toggleShowAddForm($id)
    {
        if ($this->selectedId === $id) {
            $this->selectedId = null;
        } else {
            $this->selectedId = $id;
        }
    }
}
