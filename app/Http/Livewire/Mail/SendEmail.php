<?php

namespace App\Http\Livewire\Mail;

use App\Models\Mails;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    
    public $currentPage = PAGELIST;

    public $search = "";
    
    public $user_id;
    public $subject;
    public $emailClient;
    public $nameClient;
    public $numClient;

    protected $rules = [
        'emailClient' => 'required|email',
        'nameClient' => 'required',
        'numClient' => 'required|numeric',
    ];

    protected $messages = [
        'emailClient.required' => 'L\'adresse Email du client est requis.',
        'nameClient.required' => 'Le nom complet du client est requise.',
        'numClient.required' => 'Le numéro de téléphone du client est requis.',
        'numClient.numeric' => 'Le numéro de téléphone ne doit pas avoir de lettre.',
    ];

    public function render()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;
    
        if ($role == 'Agent') {
            $proposition = Mails::when($this->search, function ($query, $search) {
                return $query->whereHas('users', function ($query) use ($search) {
                    $query->where('nameClient', 'like', '%' . $search . '%')
                        ->orWhere('emailClient', 'like', '%' . $search . '%');
                });
            })->where('user_id', $user->id)->orderBy('created_at','desc')->paginate(6);

        } else {
            $proposition = Mails::when($this->search, function ($query, $search) {
                return $query->whereHas('users', function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('nameClient', 'like', '%' . $search . '%')
                        ->orWhere('emailClient', 'like', '%' . $search . '%');
                });
            })->orderBy('created_at','desc')->paginate(6);
        }

        return view('livewire.mail.index', ['proposition' => $proposition])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function sendEmail()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id = Auth::user()->id,
            'subject' => $this->subject = "Projet LED",
            'nameClient' => $this->nameClient,
            'emailClient' => $this->emailClient,
            'numClient' => $this->numClient,
        ];

        // Save email information to the database
        Mails::create($data);

        $user = Auth::user();
        $fromName = $user ?  userName() : config('mail.from.name');
        $fromAddress = config('mail.from.address');

        // Your email sending logic here
        Mail::send('livewire.mail.body', $data, function ($message) use ($fromName, $fromAddress) {
            $message->from($fromAddress, $fromName)
                ->to($this->emailClient)
                ->subject($this->subject);
        });

        $this->reset(['subject', 'emailClient', 'nameClient', 'numClient']);
        $this->goToListPropos();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Le mail a été envoyé avec succès!"]);
    }


    public function goToListPropos()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }

    public function goToaddPropos()
    {
        $this->currentPage = PAGECREATEFORM;
    }

  
}
