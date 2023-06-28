<?php

namespace App\Http\Livewire\Mail;

use App\Models\Mails;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendEmail extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    public $search = "";
    public $selectedMonth;
    public $selectedStatus;
    public $data;

    public $user_id, $subject, $emailClient, $nameClient, $numClient, $adresse, $company, $state, $remark, $rappel;

    public $selectedFilter;

    public $editProposition;

    public $editMail = [];

    protected $rules = [
        'emailClient' => 'required|email|unique:mails,emailClient',
        'nameClient' => 'required',
        'numClient' => 'required|numeric',
        'adresse' => 'required',
        'company' => 'required',
    ];

    protected $messages = [
        'emailClient.required' => 'L\'adresse Email du client est requise.',
        'emailClient.unique' => 'L\'adresse mail a déjà été prise.',
        'nameClient.required' => 'Le nom complet du client est requis.',
        'numClient.required' => 'Le numéro de téléphone du client est requis.',
        'numClient.numeric' => 'Le numéro de téléphone ne doit pas avoir de lettre.',
        'adresse.required' => 'L\'adresse est requise.',
        'company.required' => 'La société est requise.',
    ];

    public $today;
    public $mails;

    public function mount()
    {
        $user = Auth::user();
        $manager = $user->last_name;
        $role = $user->roles->first()->name;
        $this->today = now()->toDateString();
    
        $query = Mails::whereDate('created_at', $this->today);
    
        if ($role == 'Agent') {
            $query->where('user_id', $user->id);
        }else{
        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $query->whereHas('users', fn ($q) => $q->where('group', 1));
        } elseif ($manager == 'Essaid') {
            $query->whereHas('users', fn ($q) => $q->where('group', 2));
        }
    }
        $this->mails = $query->get();
    }


    public function render()
    {
        return view('livewire.mail.today.index')
            ->extends("layouts.master")
            ->section("contenu");
    }
    
    public function goToaddPropos()
    {
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToListPropos()
    {
        $this->resetValidation();
        $this->currentPage = PAGELIST;
    }

    public function sendEmail()
    {
        $this->validate();
    
        $data = [
            'user_id' => $this->user_id = Auth::user()->id,
            'subject' => $this->subject = "PROJET LED À '' 0 EURO ''",
            'nameClient' => $this->nameClient,
            'emailClient' => $this->emailClient,
            'numClient' => $this->numClient,
            'adresse' => $this->adresse,
            'company' => $this->company,
            'state' => $this->state = '0',
            'remark' => $this->remark,
            'rappel' => $this->rappel,
        ];
    
        $user = Auth::user();
        $fromName = $user ?  auth()->user()->nom_prod  : config('mail.from.name');
        $fromAddress = config('mail.from.address');
    
        $excelFilePath = Storage::path('FICHE QUANTITATIVE.xlsx');
        $pdfFilePath = Storage::path('CATALOGUE ROBINET THERMOSTAT.pdf');
        $pdf2FilePath = Storage::path('PROJECTEURS ET HUBLOTS.pdf');
    
        $emailSent = false;
        Mail::send('livewire.mail.today.body', $data, function ($message) use ($fromName, $fromAddress, $excelFilePath, $pdfFilePath, $pdf2FilePath, &$emailSent) {
            $message->from($fromAddress, $fromName)
                ->to($this->emailClient)
                ->subject($this->subject)
                ->attach($excelFilePath, [
                    'as' => 'FICHE QUANTITATIVE.xlsx',
                    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ])
                ->attach($pdfFilePath, [
                    'as' => 'CATALOGUE ROBINET THERMOSTAT.pdf',
                    'mime' => 'application/pdf'
                ])
                ->attach($pdf2FilePath, [
                    'as' => 'PROJECTEURS ET HUBLOTS.pdf',
                    'mime' => 'application/pdf'
                ]);
    
            $emailSent = true;
        });
    
        if ($emailSent) {
            Mails::create($data);
    
            $this->reset(['subject', 'emailClient', 'nameClient', 'numClient']);
            $this->goToListPropos();
            $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Le mail a été envoyé avec succès!"]);
            return redirect()->to('/customer/proposal');
        } else {
            // Handle the case where email sending failed
            $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Échec de l'envoi de l'email. Veuillez réessayer ultérieurement."]);
        }
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
        return redirect()->to('/customer/proposal');
    }


    public function PropoRefuse()
    {
        Mails::find($this->editMail["id"])->update(["state" => "-1"]);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La proposition a été refusé!"]);
        return redirect()->to('/customer/proposal');
    }

    
    public function PropoAccepter()
    {
        Mails::find($this->editMail["id"])->update(["state" => "1"]);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "La proposition a été accepté!"]);
        return redirect()->to('/customer/proposal');
    }

    public function Rappeler()
    {
        Mails::find($this->editMail["id"])->update(["state" => "3"]);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Rappeler le client!"]);
        return redirect()->to('/customer/proposal');
    }
}
