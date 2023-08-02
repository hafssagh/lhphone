<?php

namespace App\Http\Livewire\Mail;

use App\Models\Mails;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MailAll extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGEPOPOSALL;

    public $search = "";
    public $selectedMonth;
    public $selectedStatus;
    public $data;

    public $user_id, $subject, $emailClient, $nameClient, $numClient, $adresse, $company, $state, $remark, $remark2, $rappel;

    public $selectedFilter;

    public $editProposition;

    public $editMail = [];
    public $mails;

    public function render()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $role = $user->roles->first()->name;
            $manager = $user->last_name;

            $query = Mails::query();

            if ($this->selectedStatus !== null && $this->selectedStatus !== "all") {
                $query->where('state', $this->selectedStatus);
            }

            if ($this->selectedMonth !== null && $this->selectedMonth !== "all") {
                $query->whereMonth('created_at', $this->selectedMonth);
            }

            if ($role == 'Agent') {
                $query->where('user_id', $user->id)
                    ->when($this->search, function ($query, $search) {
                        return $query->whereHas('users', function ($query) use ($search) {
                            $query->where('nameClient', 'like', '%' . $search . '%')
                                ->orWhere('emailClient', 'like', '%' . $search . '%')
                                ->orWhere('numClient', 'like', '%' . $search . '%')
                                ->orWhere('company', 'like', '%' . $search . '%');
                        });
                    });
            } else {
                $query->when($this->search, function ($query, $search) {
                    $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('company', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%')
                            ->orWhere('numClient', 'like', '%' . $search . '%');
                    });
                });
            }

            if ($manager == 'ELMOURABIT' || $manager == 'By') {
                $query->whereHas('users', fn ($q) => $q->where('group', 1));
            } elseif ($manager == 'Essaid') {
                $query->whereHas('users', fn ($q) => $q->where('group', 2));
            }

            $proposition = $query->orderBy('created_at', 'desc')->paginate(8);
        } else {
            return redirect()->route('login');
        }

        return view('livewire.mail.all.indexAll', ['proposition' => $proposition])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToListPropos()
    {
        $this->resetValidation();
        $this->currentPage = PAGEPOPOSALL;
    }

    public function goToEditMail($id)
    {
        $this->resetValidation();
        $this->editMail = Mails::with("users")->find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function updateMail()
    {
        $mail = Mails::find($this->editMail["id"]);
        $mail->fill($this->editMail);
        $mail->save();

        $this->goToListPropos();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Formulaire mise à jour avec succès!"]);
    }
}
