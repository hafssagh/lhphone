<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{

    use WithFileUploads;

    public $user;
    public $addphoto = "";
    public $nom_prod = "";


    public function render()
    {
        return view('livewire.profile.user-profile')
            ->extends("layouts.master")
            ->section("contenu");
    }


    public function mount()
    {
        $this->user = Auth::user();
        $this->nom_prod = $this->user->nom_prod;
    }
    public function updateProfile()
    {
        $this->validate([
            'nom_prod' => 'nullable',
        ]);

        $this->user->nom_prod = $this->nom_prod;
        $this->user->save();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Nom de production mis à jour avec succès!"]);
    }


    public function updateProfilePhoto()
    {
        if ($this->addphoto != null) {
            $this->user->photo = $this->addphoto->store('upload', 'public');
            $this->user->save();
            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Photo de profile mise à jour avec succès!"]);
            return redirect()->to('/profile');
        }
    }

    public function deleteProfilePhoto()
    {
        $this->user->photo = null;
        $this->user->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Photo de profile supprimé avec succès!"]);
        return redirect()->to('/profile');
    }
}
