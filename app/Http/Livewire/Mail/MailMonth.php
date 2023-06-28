<?php

namespace App\Http\Livewire\Mail;

use App\Models\Mails;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MailMonth extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGEPOPOSMONTH;

    public $search = "";
    public $selectedMonth;
    public $selectedStatus;
    public $data;

    public $user_id, $subject, $emailClient, $nameClient, $numClient, $adresse, $company, $state, $remark, $rappel;

    public $selectedFilter;

    public $editProposition;

    public $editMail = [];
    public $mails;

    public function render()
    {
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
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                });
        } else {
            $query->when($this->search, function ($query, $search) {
                $query->whereHas('users', function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('nameClient', 'like', '%' . $search . '%')
                        ->orWhere('emailClient', 'like', '%' . $search . '%');
                });
            });
        }
    
        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $query->whereHas('users', fn ($q) => $q->where('group', 1));
        } elseif ($manager == 'Essaid') {
            $query->whereHas('users', fn ($q) => $q->where('group', 2));
        }

        $Allproposition = $query->orderBy('created_at', 'desc')->without('scopes')->paginate(9);

        return view('livewire.mail.month.indexMonth', [ 'Allproposition' => $Allproposition])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function goToListPropos()
    {
        $this->resetValidation();
        $this->currentPage = PAGEPOPOSMONTH;
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

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Formulaire mise à jour avec succès!"]);
        return redirect()->to('/proposal/month');
    }


    public function PropoRefuse()
    {
        Mails::find($this->editMail["id"])->update(["state" => "-1"]);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La proposition a été refusé!"]);
        return redirect()->to('/proposal/month');
    }

    
    public function PropoAccepter()
    {
        Mails::find($this->editMail["id"])->update(["state" => "1"]);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La proposition a été accepté!"]);
        return redirect()->to('/proposal/month');
    }

    public function Rappeler()
    {
        Mails::find($this->editMail["id"])->update(["state" => "3"]);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Rappeler le client!"]);
        return redirect()->to('/proposal/month');
    }
}
