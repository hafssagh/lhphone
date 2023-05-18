<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
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

    public $currentPage = PAGELIST;


    protected $messages = [
        'newUser.first_name.required' => "Le nom de l'utilisateur est requis.",
        'newUser.last_name.required' => "Le prénom de l'utilisateur est requis.",
        'newUser.id_card.required' => "Le numéro d'identité de l'utilisateur est requis.",
        'newUser.birthday.required' => "La date de naissance de l'utilisateur est requise.",
        'newUser.email.required' => "L'adresse mail de l'utilisateur est requis.",
        'newUser.phone.required' => "Le numéro de téléphone de l'utilisateur est requis.",
        'newUser.date_contract.required' => "La date du contrat est requise.",
        'newUser.type_contract.required' => "Le type du contrat est requis.",
        'newUser.company.required' => "La société est requise.",
        'newUser.base_salary.required' => "Le salaire de base de l'utilisateur est requis.",
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        $data = ["users" => User::where("first_name", "like", "%" . $this->search . "%")
            ->orWhere("last_name", "like", "%" . $this->search . "%")
            ->latest()->paginate(4)];

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
                'editUser.id_card' => 'required',
                'editUser.birthday' => 'required',
                'editUser.phone' => 'required|numeric',
                'editUser.email' => 'required|email',
                'editUser.date_contract' => 'required',
                'editUser.type_contract' => 'required',
                'editUser.duration_contract' => 'nullable',
                'editUser.company' => 'required',
                'editUser.base_salary' => 'required|numeric',
            ];
        }
        return [
            'newUser.first_name' => 'required',
            'newUser.last_name' => 'required',
            'newUser.id_card' => 'required|unique:users,id_card',
            'newUser.birthday' => 'required',
            'newUser.phone' => 'required|numeric',
            'newUser.email' => 'required|email',
            'newUser.date_contract' => 'required',
            'newUser.type_contract' => 'required',
            'newUser.duration_contract' => 'nullable',
            'newUser.company' => 'required',
            'newUser.base_salary' => 'required|numeric',
        ];
    }

    public function goToaddUser()
    {
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

    //affiche les informations
    public function goToEditUser($id)
    {
        $this->editUser = User::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function goToListeUser()
    {
        $this->currentPage = PAGELIST;
        $this->editUser = [];
    }

    public function addUser()
    {
        /* dump($this->newUser); */
        // Vérifier que les informations sont correctes
        $validationAttributes = $this->validate();
        $validationAttributes["newUser"]["password"] =  bcrypt("password");
        //Ajouter un nouvel utilisateur
        User::create($validationAttributes["newUser"]);
        $this->newUser = [];
        $this->goToListeUser();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur créé avec succès!"]);
    }

    public function updateUser()
    {
        // Vérifier que les informations sont correctes
        $validationAttributes = $this->validate();

        User::find($this->editUser["id"])->update($validationAttributes["editUser"]);

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

}
