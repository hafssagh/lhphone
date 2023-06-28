<?php

namespace App\Http\Livewire\Explic;

use App\Models\Explic;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailExplic extends Component
{
    public $currentPage = PAGELIST;
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $search = "";
    public $user_id, $subject, $emailClient, $nameClient, $numClient, $adresse, $company;


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
        $manager = $user->last_name; 
    
        $query = Explic::query();

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
    
        $explics = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('livewire.explic.index' , ['explics' => $explics])->extends("layouts.master")
            ->section("contenu");
    }

    public function goToaddMailExplic()
    {
        $this->resetValidation();
        $this->currentPage = PAGECREATEFORM;
    }

    public function sendEmail()
    {
        $this->validate();
    
        $data = [
            'user_id' => $this->user_id = Auth::user()->id,
            'subject' => $this->subject = "Projet éclairage extérieur en LED à '' 0 EURO ''",
            'nameClient' => $this->nameClient,
            'emailClient' => $this->emailClient,
            'numClient' => $this->numClient,
            'adresse' => $this->adresse,
            'company' => $this->company,
        ];
    
        $user = Auth::user();
        $fromName = $user ?  auth()->user()->nom_prod  : config('mail.from.name');
        $fromAddress = config('mail.from.address');
    
        $emailSent = false;
        Mail::send('livewire.explic.body', $data, function ($message) use ($fromName, $fromAddress, &$emailSent) {
            $message->from($fromAddress, $fromName)
                ->to($this->emailClient)
                ->subject($this->subject);
    
            $emailSent = true;
        });
    
        if ($emailSent) {
            Explic::create($data);
    
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
