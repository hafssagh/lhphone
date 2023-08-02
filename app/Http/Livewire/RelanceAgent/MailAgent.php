<?php

namespace App\Http\Livewire\RelanceAgent;

use Livewire\Component;
use App\Models\AgentRelance;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MailAgent extends Component
{
    public $currentPage = PAGELIST;
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    public $search = "";
    public $user_id, $subject, $company, $emailClient, $nameClient, $numClient, $send;

    protected $rules = [
        'emailClient' => 'required|email|unique:mails,emailClient',
        'company' => 'required',
        'subject' => 'required',
    ];

    protected $messages = [
        'emailClient.required' => 'L\'adresse Email du client est requise.',
        'emailClient.unique' => 'L\'adresse mail a déjà été prise.',
        'company.required' => 'La société est requise.',
        'subject.required' => 'L\'objet du mail est requis.',
    ];

    public function render()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $role = $user->roles->first()->name;
            $manager = $user->last_name;

            $query = AgentRelance::query();

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

            $relances = $query->orderBy('created_at', 'desc')->paginate(14);
        } else {
            return redirect()->route('login');
        }

        return view('livewire.relance-agent.index', ["relances" => $relances])
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
            'nameClient' => $this->nameClient,
            'emailClient' => $this->emailClient,
            'numClient' => $this->numClient,
            'company' => $this->company,
            'send' => $this->send,
        ];

        $user = Auth::user();
        $fromName = $user ?  auth()->user()->nom_prod  : config('mail.from.name');
        $fromAddress = config('mail.from.address');

        $excelFilePath = Storage::path('FICHE QUANTITATIVE.xlsx');
        $pdfFilePath = Storage::path('CATALOGUE ROBINET THERMOSTAT.pdf');
        $pdf2FilePath = Storage::path('PROJECTEURS ET HUBLOTS.pdf');

        $emailSent = false;

        if ($this->send == "rive") {
            Mail::send('livewire.relance-agent.body', $data, function ($message) use ($fromName, $fromAddress, $excelFilePath, $pdfFilePath, $pdf2FilePath, &$emailSent) {
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
        } elseif ($this->send == "s2ee") {
            Mail::send('livewire.relance-agent.body', $data, function ($message) use ($fromName, $fromAddress, &$emailSent) {
                $message->from($fromAddress, $fromName)
                    ->to($this->emailClient)
                    ->subject($this->subject);

                $emailSent = true;
            });
        }

        if ($emailSent) {
            AgentRelance::create($data);

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
