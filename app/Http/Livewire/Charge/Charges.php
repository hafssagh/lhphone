<?php

namespace App\Http\Livewire\Charge;

use App\Models\Charge;
use Livewire\Component;
use Livewire\WithFileUploads;

class Charges extends Component
{
    use WithFileUploads;

    public $currentPage = PAGELIST;

    public $newCharges = [];
    public $editCharges = [];

    public function render()
    {
        if (auth()->check()) {
            $query = Charge::query();
            $query2 = Charge::query();

            $chargesLH = $query->where('company', 'lh')->orderBy('created_at', 'desc')->get();
            $chargesH2F = $query2->where('company', 'h2f')->orderBy('created_at', 'desc')->get();
        } else {
            return redirect()->route('login');
        }

        return view('livewire.charge.index', ['chargesLH' => $chargesLH, 'chargesH2F' => $chargesH2F])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToaddCharge()
    {
        $this->newCharges = "";
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToaddCharge2()
    {
        $this->newCharges = "";
        $this->currentPage = PAGECREATEFORM2;
    }

    public function addNewCharge()
    {
        $this->validate([
            'newCharges.object' => 'required',
            'newCharges.price' => 'required',
            'newCharges.file' => 'nullable|file',
        ], [
            'newCharges.object.required' => "L'object de la charge est requise.",
            'newCharges.price.required' => "Le prix de la charge est requise.",
            'newCharges.file.file' => "Le fichier doit être valide.",
        ]);

        $charge = new Charge();

        $charge->object = $this->newCharges["object"];
        $charge->price = $this->newCharges["price"];
        $charge->company = $this->newCharges["company"] = 'lh';
        $charge->file = $this->newCharges["file"] ?? 0;

        if ($file =  $charge->file) {
            $filePath = $file->store('public/charge_files');
            $charge->file = $filePath;
        }

        $charge->save();
        $this->newCharges = "";
        $this->goToListeCharges();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Une nouvelle charge a été ajoutée avec succès!"]);
    }

    public function addNewCharge2()
    {
        $this->validate([
            'newCharges.object' => 'required',
            'newCharges.price' => 'required',
            'newCharges.file' => 'nullable|file',
        ], [
            'newCharges.object.required' => "L'object de la charge est requise.",
            'newCharges.price.required' => "Le prix de la charge est requise.",
            'newCharges.file.file' => "Le fichier doit être valide.",
        ]);

        $charge = new Charge();

        $charge->object = $this->newCharges["object"];
        $charge->price = $this->newCharges["price"];
        $charge->company = $this->newCharges["company"] = 'h2f';
        $charge->file = $this->newCharges["file"] ?? 0;

        if ($file =  $charge->file) {
            $filePath = $file->store('public/charge_files');
            $charge->file = $filePath;
        }

        $charge->save();
        $this->newCharges = "";
        $this->goToListeCharges();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Une nouvelle charge a été ajoutée avec succès!"]);
    }

    public function goToListeCharges()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }
}
