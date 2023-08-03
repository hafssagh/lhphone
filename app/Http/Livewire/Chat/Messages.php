<?php

namespace App\Http\Livewire\Chat;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Messages extends Component
{
    public $sender;
    public $message;
    public $allmessages;
    public $search = "";

    public function render()
    {
        Carbon::setLocale("fr");
        
        
            $today = Carbon::now()->format('Y-m-d');
            $user = Auth::user();
            $manager = $user->last_name;
            $company = $user->company;
            $group = $user->group;
            $role = $user->roles->first()->name;

            $usersQuery = User::whereNotExists(function ($query) use ($today) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereNot('resignations.date', $today);
            })->when($this->search, function ($query, $search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            });

            if ($manager == 'EL MESSIOUI') {
                $usersQuery;
            } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
                $usersQuery->where('group', 1)->orWhereHas('roles', function ($query) {
                    $query->where('name', 'manager')
                        ->orWhere('name', 'Super Administrateur')
                        ->orWhere('name', 'Administrateur');
                })->whereNot('company', 'h2f')->whereNot('last_name', 'Essaid');
            } elseif ($manager == 'Essaid') {
                $usersQuery->where('group', 2)->orWhereHas('roles', function ($query) {
                    $query->where('name', 'manager')
                        ->orWhere('name', 'Super Administrateur')
                        ->orWhere('name', 'Administrateur');
                })->whereNot('company', 'h2f')->whereNot('last_name', 'ELMOURABIT')->whereNot('last_name', 'By');
            } elseif ($manager == 'Hdimane') {
                $usersQuery->where('company', 'h2f')->orWhereHas('roles', function ($query) {
                    $query
                        ->orWhere('name', 'Super Administrateur')
                        ->orWhere('name', 'Administrateur');
                })->whereNot('company', 'lh');
            } elseif ($role == 'Agent' && $company == 'lh' && $group == '1') {
                $usersQuery->whereHas('roles', function ($query) {
                    $query->whereNot('name', 'agent');
                })->where('company', 'lh')->whereNot('last_name', 'Essaid');
            } elseif ($role == 'Agent' && $company == 'lh' && $group == '2') {
                $usersQuery->whereHas('roles', function ($query) {
                    $query->whereNot('name', 'agent');
                })->where('company', 'lh')->whereNot('last_name', 'ELMOURABIT')->whereNot('last_name', 'By');
            } elseif ($role == 'Agent' && $company == 'h2f') {
                $usersQuery->whereHas('roles', function ($query) {
                    $query->whereNot('name', 'agent');
                })->where('company', 'h2f');
            } else {
                $usersQuery;
            }


            $users = $usersQuery->get();

            $sender = $this->sender;
            $this->allmessages;
        


        return view('livewire.chat.messages', ['users' => $users, 'sender' => $sender])
            ->extends("layouts.master")
            ->section("contenu");
    }

    public function mountdata()
    {

        if (isset($this->sender->id)) {
            $this->allmessages = Message::where('user_id', auth()->id())
                ->where('receiver_id', $this->sender->id)->orWhere('user_id', $this->sender->id)
                ->where('receiver_id', auth()->id())->orderBy('id', 'asc')->get();

            $not_seen = Message::where('user_id', $this->sender->id)
                ->where('receiver_id', auth()->id())->where('is_seen', false);
            $not_seen->update(['is_seen' => true]);
        }
    }

    public function resetForm()
    {
        $this->message = '';
    }

    public function SendMessage()
    {
        $data = new Message;
        $data->message = $this->message;
        $data->user_id = auth()->id();
        $data->receiver_id = $this->sender->id;
        $data->save();

        $this->resetForm();
    }

    public function getUser($userId)
    {

        $user = User::find($userId);
        $this->sender = $user;
        $this->allmessages = Message::where('user_id', auth()->id())
            ->where('receiver_id', $userId)->orWhere('user_id', $userId)->where('receiver_id', auth()->id())
            ->orderBy('id', 'asc')->get();
    }
}
