<?php

namespace App\Http\Livewire\Mail;

use Carbon\Carbon;
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
    public $selectedMonth;

    public $user_id, $subject, $emailClient, $nameClient, $numClient, $adresse, $company, $state, $remark;

    public $selectedFilter;

    public $editProposition;

    protected $rules = [
        'emailClient' => 'required|email',
        'nameClient' => 'required',
        'numClient' => 'required|numeric',
        'adresse' => 'required',
        'company' => 'required',
    ];

    protected $messages = [
        'emailClient.required' => 'L\'adresse Email du client est requis.',
        'nameClient.required' => 'Le nom complet du client est requise.',
        'numClient.required' => 'Le numéro de téléphone du client est requis.',
        'numClient.numeric' => 'Le numéro de téléphone ne doit pas avoir de lettre.',
        'adresse.required' => 'L\'adresse est requis.',
        'company.required' => 'La société est requis.',
    ];

    public $today;
    public $mails;

    public function mount()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;

        $this->today = now()->toDateString();
        if ($role == 'Agent') {
            $this->mails = Mails::where('user_id', $user->id)->whereDate('created_at', $this->today)->get();
        } else {
            $this->mails = Mails::whereDate('created_at', $this->today)->get();
        }
    }

    public function mailValide($id, $state)
    {
        $mail = Mails::find($id);
        $mail->state = $state;
        $mail->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Mise à jour réaliée avec succès!"]);
        return redirect()->to('/customer/proposal');
    }


    public function render()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;

        if ($this->selectedMonth === null || $this->selectedMonth == "all") {
            if ($role == 'Agent') {
                $proposition = Mails::when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->where('user_id', $user->id)
                    ->whereDate('created_at', '>=', fetchWeekDates()[0])
                    ->whereDate('created_at', '<=', fetchWeekDates()[6])
                    ->orderBy('created_at', 'desc')->paginate(8);

                $Allproposition = Mails::when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')->paginate(8);
            } else {
                $proposition = Mails::when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->whereDate('created_at', '>=', fetchWeekDates()[0])
                    ->whereDate('created_at', '<=', fetchWeekDates()[6])
                    ->orderBy('created_at', 'desc')->paginate(8);

                $Allproposition = Mails::when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->orderBy('created_at', 'desc')->paginate(8);
            }
        } else {
            if ($role == 'Agent') {
                $proposition = Mails::whereMonth('created_at', $this->selectedMonth)->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->where('user_id', $user->id)
                    ->whereDate('created_at', '>=', fetchWeekDates()[0])
                    ->whereDate('created_at', '<=', fetchWeekDates()[6])
                    ->orderBy('created_at', 'desc')->paginate(8);

                $Allproposition = Mails::whereMonth('created_at', $this->selectedMonth)->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')->paginate(8);
            } else {
                $proposition = Mails::whereMonth('created_at', $this->selectedMonth)->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->whereDate('created_at', '>=', fetchWeekDates()[0])
                    ->whereDate('created_at', '<=', fetchWeekDates()[6])
                    ->orderBy('created_at', 'desc')->paginate(8);

                $Allproposition = Mails::whereMonth('created_at', $this->selectedMonth)->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('nameClient', 'like', '%' . $search . '%')
                            ->orWhere('emailClient', 'like', '%' . $search . '%');
                    });
                })
                    ->orderBy('created_at', 'desc')->paginate(8);
            }
        }
        return view('livewire.mail.index', ['proposition' => $proposition, 'Allproposition' => $Allproposition])
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
            'adresse' => $this->adresse,
            'company' => $this->company,
            'state' => $this->state = '0',
            'remark' => $this->remark,
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

    public function goToPropWeek()
    {
        $this->currentPage = PAGEPOPOSWEEK;
    }

    public function goToPropMonth()
    {
        $this->currentPage = PAGEPOPOSMONTH;
    }
}
