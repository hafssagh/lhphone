<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class UserProfile extends Component
{

    use WithFileUploads;

    public $user;
    public $addphoto="";


    public function render()
    {
        return view('livewire.profile.user-profile')
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function mount(){
        $this->user = Auth::user();
    }

     public function updateProfilePhoto()
    {
        if($this->addphoto != null){
            $this->user->photo = $this->addphoto->store('upload','public');
            $this->user->save();
            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Photo de profils mise à jour avec succès!"]);      
        }
    }
}
