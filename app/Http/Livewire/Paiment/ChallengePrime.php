<?php

namespace App\Http\Livewire\Paiment;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ChallengePrime extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $selectedSocieties = [];
    public $search = "";

    public function render()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $manager = $user->last_name;

            $challenge = User::whereNot('challenge', '0')
                ->select('first_name', 'last_name', 'challenge', 'company', 'photo')
                ->where(function ($query) {
                    $query->orderBy('last_name')
                        ->where('company', $this->selectedSocieties)
                        ->where("first_name", "like", "%" . $this->search . "%")
                        ->orWhere("last_name", "like", "%" . $this->search . "%");
                })
                ->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
                    $query->where('group', 1);
                })
                ->when($manager == 'Essaid ', function ($query) {
                    $query->where('group', 2);
                })
                ->when($manager == 'Hdimane', function ($query) {
                    $query->where('company', 'h2f');
                })
                ->paginate(6);

            $prime = User::whereNot('prime', '0')
                ->select('first_name', 'last_name', 'prime', 'company', 'photo')
                ->where(function ($query) {
                    $query->orderBy('last_name')
                        ->where('company', $this->selectedSocieties)
                        ->where("first_name", "like", "%" . $this->search . "%")
                        ->orWhere("last_name", "like", "%" . $this->search . "%");
                })
                ->when($manager == 'ELMOURABIT' || $manager == 'By', function ($query) {
                    $query->where('group', 1);
                })
                ->when($manager == 'Essaid', function ($query) {
                    $query->where('group', 2);
                })
                ->when($manager == 'Hdimane', function ($query) {
                    $query->where('company', 'h2f');
                })
                ->paginate(6);
        } else {
            return redirect()->route('login');
        }

        return view(
            'livewire.paiment.challenge-prime',
            ["challenge" => $challenge, "prime" => $prime]
        )
            ->extends("layouts.master")
            ->section("contenu");
    }
}
