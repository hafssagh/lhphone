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

    public function render()
    {
        Carbon::setLocale("fr");
        $today = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $manager = $user->last_name;
        $role = $user->roles->first()->name;
        
        $usersQuery = User::whereNotExists(function ($query)  use ($today)  {
            $query->select(DB::raw(1))
                ->from('resignations')
                ->whereRaw('resignations.user_id = users.id')
                ->whereNot('resignations.date', $today);
        });

        if ($manager == 'EL MESSIOUI') {
            $usersQuery;
        } elseif ($manager == 'ELMOURABIT' || $manager == 'By') {
            $usersQuery->where('group', 1)->orWhereHas('roles', function ($query) {
                $query->where('name', 'manager')->orWhere('name', 'Super Administrateur')->orWhere('name', 'Administrateur');
            });
        } elseif ($manager == 'Essaid') {
            $usersQuery->where('group', 2)->orWhereHas('roles', function ($query) {
                $query->where('name', 'manager')->orWhere('name', 'Super Administrateur')->orWhere('name', 'Administrateur');
            });
        }elseif ($manager == 'Hdimane') {
            $usersQuery->where('company', 'h2f')->orWhereHas('roles', function ($query) {
                $query->where('name', 'manager')->orWhere('name', 'Super Administrateur')->orWhere('name', 'Administrateur');
            });
        }elseif ($role == 'agent') {
            $usersQuery->orWhereHas('roles', function ($query) {
                $query->where('name', 'manager')->orWhere('name', 'Super Administrateur')->orWhere('name', 'Administrateur');
            });
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
