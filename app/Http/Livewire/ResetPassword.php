<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{

    public $current_password;
    public $new_password;
    public $confirmation_password;
    public $error;
    public $error1;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:6',
        'confirmation_password' => 'required',
    ];


    protected $messages = [
        'current_password.required' => "Le mot de passe est requis.",
        'new_password.required' => "Le mot de passe est requis.",
        'new_password.min' => " Le mot de passe doit comporter au moins 6 caractères.",
        'confirmation_password.required' => "La confirmation du mot de passe est requise.",
    ];

    public function render()
    {
        return view('livewire.profile.reset-password')
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function updatePassword()
    {
        $this->validate();
        $user = Auth::user();
        $auth_password = $user->password;
        if (Hash::check($this->current_password, $auth_password)) {
            if ($this->new_password == $this->confirmation_password) {
                $user->update(['password' =>  Hash::make($this->new_password)]);
                $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Mot de passe utilisateur réinitialisé avec succès!"]);
                $this->resetForm();
            } else {
                $this->error = "Les deux mots de passe ne sont pas identiques.";
            }
        } else {
            $this->error1 = "Le mot de passe actuelle est incorrecte.";
        }
    }

    public function resetForm()
    {
        $this->current_password = null;
        $this->new_password = null;
        $this->confirmation_password = null;
    }
}
