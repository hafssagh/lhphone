<?php

namespace App\Http\Livewire\User;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $newUser = [];
    public $editUser = [];
    public $roleUser = [];
    public $rolePermissions = [];

    public $search = "";
    public $selectedCompany;

    public $currentPage = PAGELIST;


    protected $messages = [
        'newUser.first_name.required' => "Le nom de l'utilisateur est requis.",
        'newUser.last_name.required' => "Le prénom de l'utilisateur est requis.",
        'newUser.email.required' => "L'adresse mail de l'utilisateur est requis.",
        'newUser.email.unique' => "L'adresse mail a déjà été prise.",
        'newUser.email.numeric' => "Le numéro de téléphone ne doit pas avoir de lettre.",
        'newUser.rib.numeric' => "Le rib ne doit pas avoir de lettre.",
        'newUser.rib.digits' => "Le rib doit avoir 24 chiffres.",
        'newUser.type_contract.required' => "Le type du contrat est requis.",
        'newUser.company.required' => "La société est requise.",
        'editUser.first_name.required' => "Le nom de l'utilisateur est requis.",
        'editUser.last_name.required' => "Le prénom de l'utilisateur est requis.",
        'editUser.email.required' => "L'adresse mail de l'utilisateur est requis.",
        'editUser.email.unique' => "L'adresse mail a déjà été prise.",
        'editUser.email.numeric' => "Le numéro de téléphone ne doit pas avoir de lettre.",
        'editUser.rib.numeric' => "Le rib ne doit pas avoir de lettre.",
        'editUser.rib.digits' => "Le rib doit avoir 24 chiffres.",
        'editUser.type_contract.required' => "Le type du contrat est requis.",
        'editUser.company.required' => "La société est requise.",
    ];

    public function render()
    {
        Carbon::setLocale("fr");
        $user = Auth::user();
        $role = $user->roles->first()->name;
        $search = "%" . $this->search . "%";
        $manager = $user->last_name;

        $query = User::where(function ($query) use ($search) {
            $query->where("first_name", "like", $search)
                ->orWhere("last_name", "like", $search);
        })
            ->orderBy("last_name");

        if ($role == 'Administrateur' || $role == 'Super Administrateur') {
            if ($this->selectedCompany !== null && $this->selectedCompany != "all") {
                $query->where('company', $this->selectedCompany);
            }
        } elseif ($role == 'Manager') {
           
            if ($manager == 'EL MESSIOUI') {
                $query->latest();
            } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
                $query->where("company", "like", "lh")->where('group', 1)  ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })->latest();
            } elseif ($manager == 'Essaid') {
                $query->where("company", "like", "lh")->where('group', 2)  ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })->latest();
            } elseif ($manager == 'Hdimane') {
                $query->where("company", "like", "h2f")
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agent');
                })
                ->latest();
            }
        }

        $users = $query->whereNot('last_name' , 'EL MESSIOUI')->paginate(10);

        $data = [
            "users" => $users,
        ];

        return view('livewire.users.index', $data)
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function rules()
    {
        if ($this->currentPage == PAGEEDITFORM) {
            return [
                'editUser.first_name' => 'required',
                'editUser.last_name' => 'required',
                'editUser.id_card' => 'nullable',
                'editUser.birthday' => 'nullable',
                'editUser.phone' => 'nullable|numeric',
                'editUser.email' => 'required|email',
                'editUser.type_virement' => 'nullable',
                'editUser.type_contract' => 'required',
                'editUser.duration_contract' => 'nullable',
                'editUser.rib' => 'nullable|numeric|digits:24',
                'editUser.date_contract' => 'nullable',
                'editUser.group' => 'nullable',
                'editUser.company' => 'required',
                'editUser.base_salary' => 'nullable|numeric',
            ];
        }
        return [
            'newUser.first_name' => 'required',
            'newUser.last_name' => 'required',
            'newUser.id_card' => 'nullable|unique:users,id_card',
            'newUser.birthday' => 'nullable',
            'newUser.phone' => 'nullable|numeric',
            'newUser.email' => 'required|email|unique:users,email',
            'newUser.type_virement' => 'nullable',
            'newUser.type_contract' => 'required',
            'newUser.rib' => 'nullable|numeric|digits:24',
            'newUser.date_contract' => 'nullable',
            'newUser.duration_contract' => 'nullable',
            'newUser.group' => 'nullable',
            'newUser.company' => 'required',
            'newUser.base_salary' => 'nullable|numeric',
        ];
    }

    public function goToaddUser()
    {
        $this->resetValidation();
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToRoleUser($id)
    {
        $this->roleUser = User::find($id)->toArray();
        $this->currentPage = PAGEROLE;

        $this->populateRole();
    }

    public function populateRole()
    {
        $this->rolePermissions["roles"] = [];

        $mapForCB = function ($value) {
            return $value["id"];
        };

        $roleIds = array_map($mapForCB, User::find($this->roleUser["id"])->roles->toArray());

        foreach (Role::all() as $role) {
            if (in_array($role->id, $roleIds)) {
                array_push($this->rolePermissions["roles"], ["role_id" => $role->id, "role_name" => $role->name, "active" => true]);
            } else {
                array_push($this->rolePermissions["roles"], ["role_id" => $role->id, "role_name" => $role->name, "active" => false]);
            }
        }
    }

    public function updateRole()
    {
        DB::table("user_role")->where("user_id", $this->roleUser["id"])->delete();

        foreach ($this->rolePermissions["roles"] as $role) {
            if ($role["active"]) {
                User::find($this->roleUser["id"])->roles()->attach($role["role_id"]);
            }
        }
        $this->goToListeUser();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Rôles mis à jour avec succès!"]);
    }


    public function goToEditUser($id)
    {
        $this->resetValidation();
        $this->editUser = User::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function goToListeUser()
    {
        $this->currentPage = PAGELIST;
    }

    public function addUser()
    {
        $validationAttributes = $this->validate();
        $validationAttributes["newUser"]["password"] =  bcrypt("password");
        
        $user = User::create($validationAttributes["newUser"]);
        
        $agentRole = Role::where('name', 'agent')->first();
        if ($agentRole) {
            $user->roles()->attach($agentRole->id);
        }
        workHours();
        AbsSalary();
        $this->newUser = [];
        $this->goToListeUser();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur créé avec succès!"]);
    }

    public function updateUser()
    {
        
        $validationAttributes = $this->validate();

        User::find($this->editUser["id"])->update($validationAttributes["editUser"]);
        AbsSalary();

        $this->goToListeUser();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur mise à jour avec succès!"]);
    }

    public function confirmDelete($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer $name, êtes-vous sûr de continuer?",
            "type" => "warning",
            "data" => [
                "user_id" => $id
            ]
        ]]);
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur supprimé avec succès!"]);
    }

    public function confirmPwdReset()
    {
        User::find($this->editUser["id"])->update(["password" => Hash::make(DEFAULTPASSWORD)]);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Mot de passe utilisateur réinitialisé avec succès!"]);
    }

    public $additionalOptionEnabled = 'false';

    public function updatedNewUserCompany($value)
    {
        if ($value === 'lh') {
            $this->additionalOptionEnabled = true;
        } else {
            $this->additionalOptionEnabled = false;
        }
    }
}
