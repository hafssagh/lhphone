<?php

namespace App\Http\Livewire\RelanceManger;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ManagerRelance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailManager extends Component
{
    public $currentPage = PAGELIST;
    use WithPagination;
    
    protected $paginationTheme = "bootstrap";
    public $search = "";
    public $user_id, $subject, $company, $emailClient, $nameClient, $numClient, $date_envoie,
    $numDevie, $object;
    
    protected $rules = [
        'emailClient' => 'required|email|unique:mails,emailClient',
        'company' => 'required',
    ];

    protected $messages = [
        'emailClient.required' => 'L\'adresse Email du client est requise.',
        'emailClient.unique' => 'L\'adresse mail a déjà été prise.',
        'company.required' => 'La société est requise.',
    ];

    public function render()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;

        $query = ManagerRelance::query();

        if ($role == 'Manager') {
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
    
        $relances = $query->orderBy('created_at', 'desc')->paginate(14);
        
        return view('livewire.relance-manager.index'  , [ "relances" => $relances])
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function goToaddMailRelance()
    {
        $this->resetValidation();
        $this->currentPage = PAGECREATEFORM;
    }

    public function sendEmail()
    {
        $this->validate();
    
        $data = [
            'user_id' => $this->user_id = Auth::user()->id,
            'subject' => $this->subject,     
            'company' => $this->company,
            'nameClient' => $this->nameClient,
            'emailClient' => $this->emailClient,
            'numDevie' => $this->numDevie,
            'numClient' => $this->numClient,
            'date_envoie' => $this->date_envoie,
            'object' => $this->object,
        ];
    
        $user = Auth::user();
        $fromName = $user ?  auth()->user()->nom_prod  : config('mail.from.name');
        $fromAddress = config('mail.from.address');
    
        $emailSent = false;
        Mail::send('livewire.relance-manager.body', $data, function ($message) use ($fromName, $fromAddress, &$emailSent) {
            $message->from($fromAddress, $fromName)
                ->to($this->emailClient)
                ->subject($this->subject);
    
            $emailSent = true;
        });
    
        if ($emailSent) {
            ManagerRelance::create($data);
    
            $this->reset(['subject', 'emailClient', 'nameClient', 'numClient']);
            $this->goToListMail();
            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Le mail a été envoyé avec succès!"]);
        
        } else {
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Échec de l'envoi de l'email. Veuillez réessayer ultérieurement."]);
        }
    }

    public function goToListMail()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }
}
