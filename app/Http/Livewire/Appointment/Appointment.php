<?php

namespace App\Http\Livewire\Appointment;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appoint;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Appointment extends Component
{
    public $state;

    public $search = "";
    public $selectedStatus;

    public $newAppointment = [];
    public $editAppointment = [];

    public $selectedId;

    public $currentPage = PAGELIST;
    
    public function render()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;

        $query = Appoint::query();

        if ($this->selectedStatus !== null && $this->selectedStatus !== "all") {
            $query->where('state', $this->selectedStatus);
        }

        if ($role == 'Agent') {
            $query->where('user_id', $user->id)
                ->when($this->search, function ($query, $search) {
                    return $query->whereHas('users', function ($query) use ($search) {
                        $query->where('name_client', 'like', '%' . $search . '%');
                    });
                });
        } else {
            $query->when($this->search, function ($query, $search) {
                $query->whereHas('users', function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('name_client', 'like', '%' . $search . '%');
                });
            });
        }

        $appointment = $query->orderBy('created_at', 'desc')->paginate(9);

        $currentMonth = Carbon::now()->format('Y-m');
        $usersQuery = User::select('id', 'first_name', 'last_name')
            ->where('company', 'h2f')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->whereNotExists(function ($query)  use ($currentMonth) {
                $query->select(DB::raw(1))
                    ->from('resignations')
                    ->whereRaw('resignations.user_id = users.id')
                    ->whereRaw("DATE_FORMAT(resignations.date, '%Y-%m') != ?", [$currentMonth]);
            })
            ->orderBy('last_name')->get();


        return view('livewire.appointment.index', ['appointment' => $appointment, 'users' => $usersQuery])->extends("layouts.master")
            ->section("contenu");
    }

    public function goToaddAppointment()
    {
        $this->newAppointment = "";
        $this->currentPage = PAGECREATEFORM;
    }

}
