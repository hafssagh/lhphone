<?php

namespace App\Http\Livewire\Production;

use App\Models\Sale;
use App\Models\User;
use App\Models\Mails;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Sales extends Component
{
    public $state;

    public $search = "";
    public $selectedStatus;

    public $newSale = [];
    public $editSale = [];

    public $selectedId;

    public $currentPage = PAGELIST;

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function render()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;
        $manager = $user->last_name;


        $query = Sale::select('sales.*')
            ->join('mails', 'mails.user_id', '=', 'sales.user_id')
            ->orderBy('sales.date_sal', 'desc')
            ->when($this->state, fn ($q, $state) => $q->where('sales.state', $state))
            ->when($this->search, fn ($q, $search) => $q->whereHas(
                'users',
                fn ($q) => $q->where('users.first_name', 'like', "%$search%")
                    ->orWhere('users.last_name', 'like', "%$search%")
                    ->orWhere('sales.name_client', 'like', "%$search%")
            ))->latest();
        if ($role == 'Agent') {
            $query->where('mails.user_id', $user->id);
        }

        if ($this->selectedStatus !== null && $this->selectedStatus !== "all") {
            $query->where('sales.state', $this->selectedStatus);
        }

        $selectedUserId = $this->newSale;

        $usersQuery = User::join('mails', 'mails.user_id', '=', 'users.id')
            ->select('users.id', 'users.first_name', 'users.last_name')
            ->where('users.company', 'lh')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->orderBy('last_name')
            ->when($selectedUserId, function ($query, $selectedUserId) {
                $query->where('users.id', $selectedUserId);
            });

        if ($role == 'Agent') {
            $mailsQuery = Mails::where('user_id', $user->id)->where('state', '1')->latest()->get();
        } else {
            $mailsQuery = Mails::where('user_id', $selectedUserId)->where('state', '1')->latest()->get();
        }
        // Disable ONLY_FULL_GROUP_BY mode
        DB::statement('SET sql_mode=(SELECT REPLACE(@@sql_mode, "ONLY_FULL_GROUP_BY", ""));');

        if ($manager == 'EL MESSIOUI') {
            $users = $usersQuery->groupBy('users.id')->get();
            $sales = $query->groupBy('sales.id')->paginate(9);
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $users = $usersQuery->where('group', 1)->groupBy('users.id')->get();
            $sales = $query->whereHas('users', fn ($q) => $q->where('group', 1))
                ->groupBy('sales.id')
                ->paginate(9);
        } elseif ($manager == 'Essaid') {
            $users = $usersQuery->where('group', 2)->groupBy('users.id')->get();
            $sales = $query->whereHas('users', fn ($q) => $q->where('group', 2))
                ->groupBy('sales.id')
                ->paginate(9);
        } else {
            $users = $usersQuery->groupBy('users.id')->get();
            $sales = $query->groupBy('sales.id')->paginate(7);
        }

        return view('livewire.sale.index', [
            "sales" => $sales, "users" => $users, 'mails' => $mailsQuery,
        ])
            ->extends("layouts.master")
            ->section("contenu");
    }


    public function addNewSale()
    {
        $this->validate([
            'newSale.quantity' => 'required',
            'newSale.name_client' => 'required|unique:sales,name_client',
        ], [
            'newSale.quantity.required' => "La quantité est requise.",
            'newSale.name_client.required' => "Le nom de la société est requis.",
            'newSale.name_client.unique' => "Le nom de la société doit être unique.",
        ]);

        $mails = Mails::where('company', $this->newSale["name_client"])->first();
        $sale = new Sale;

        $user = Auth::user();
        $role = $user->roles->first()->name;

        if ($role == 'Agent') {
            $sale->user_id = $user->id;
        } else {
            $sale->user_id = $this->newSale["user"];
        }
        $sale->quantity = $this->newSale["quantity"];
        $sale->state = $this->newSale["state"] = "2";
        $sale->date_sal = $this->newSale["date_sal"] = date('Y-m-d');
        $sale->date_confirm = $this->newSale["date_confirm"] ?? null;
        $sale->name_client = $this->newSale["name_client"];
        $sale->mail_client = $mails->emailClient ?? null;
        $sale->phone_client = $mails->numClient ?? null; 
        $sale->remark = $mails->send ?? null;
        /* $sale->remark = $this->newSale["remark"] ?? null; */
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


    public function filterState($state = null)
    {
        $this->state = $state;
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
        $this->currentPage = PAGELIST;
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
        if ($sale->state == '1' || $sale->state == '-1') {
            $sale->date_confirm = now()->toDateString();
        }
        $sale->save();
        CalculChallenge();
        CalculPrime();
        $this->goToListeSales();
        $this->dispatchBrowserEvent("showSuccessMessage");
    }

    public function goToaddSale()
    {
        $this->newSale = "";
        $this->currentPage = PAGECREATEFORM;
    }
}
