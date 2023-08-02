<div class="row">
    <div class="col-md-12">
        <div class="card" id="chat3" style="border-radius: 15px;">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">


                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.debounce.500ms="search"
                                placeholder="Rechercher ...">
                            <span class="input-group-text"><i class="icon-search"></i></span>
                        </div>

                        <div class="p-3">
                            <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
                                <ul class="list-unstyled mb-0 list-container3">
                                    @foreach ($users->sortByDesc(function ($user) {
        $lastMessage = App\Models\Message::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('receiver_id', auth()->id());
        })->orWhere(function ($query) use ($user) {
                $query->where('user_id', auth()->id())->where('receiver_id', $user->id);
            })->orderByDesc('created_at')->first();

        return $lastMessage ? $lastMessage->created_at : null;
    }) as $user)
                                        @if ($user->id !== auth()->id())
                                            @php
                                                $not_seen =
                                                    App\Models\Message::where('user_id', $user->id)
                                                        ->where('receiver_id', auth()->id())
                                                        ->where('is_seen', false)
                                                        ->get() ?? null;
                                                
                                                $lastMessage = App\Models\Message::where(function ($query) use ($user) {
                                                    $query->where('user_id', $user->id)->where('receiver_id', auth()->id());
                                                })
                                                    ->orWhere(function ($query) use ($user) {
                                                        $query->where('user_id', auth()->id())->where('receiver_id', $user->id);
                                                    })
                                                    ->orderByDesc('created_at')
                                                    ->first();
                                            @endphp
                                            <a wire:click="getUser({{ $user->id }})" class="text-dark link"
                                                style="text-decoration: none;">
                                                <li class="p-2 border-bottom">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                @if ($user->photo != '' || $user->photo != null)
                                                                    <img src="{{ asset('storage/' . $user->photo) }}"
                                                                        alt="avatar"
                                                                        class="img rounded-circle d-flex align-self-center me-3"
                                                                        width="45" height="45">
                                                                @else
                                                                    <img src="../assets/images/user.png" alt="avatar"
                                                                        class="d-flex align-self-center me-3"
                                                                        width="45" height="45">
                                                                @endif
                                                                <span class="badge bg-success badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">{{ $user->last_name }}
                                                                    {{ $user->first_name }}</p>
                                                                <p class="small text-muted">
                                                                    {{ $lastMessage ? $lastMessage->message : 'Aucun message' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">
                                                                {{ $lastMessage ? $lastMessage->created_at->format('H:i') : '' }}
                                                            </p>
                                                            @if (filled($not_seen))
                                                                <span class="badge bg-danger rounded-pill float-end">
                                                                    {{ $not_seen->count() }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            </a>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-7 col-xl-8">
                        <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true"
                            style="position: relative; height: 600px">
                            <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 100px">
                                <ul class="list-unstyled mb-0 ">
                                    <li class="p-2 border-bottom">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex flex-row">
                                                <div>
                                                    @if (isset($sender))
                                                        @if ($sender->photo != '' || $sender->photo != null)
                                                            <img src="{{ asset('storage/' . $sender->photo) }}"
                                                                alt="avatar"
                                                                class="img rounded-circle d-flex align-self-center me-3"
                                                                width="50" height="50">
                                                        @else
                                                            <img src="../assets/images/user.png" alt="avatar"
                                                                class="d-flex align-self-center me-3" width="50"
                                                                height="50">
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="pt-1">
                                                    <h4 class="fw-bold mb-0">
                                                        @if (isset($sender))
                                                            {{ $sender->last_name }} {{ $sender->first_name }}
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="list-container4" style="display: flex; flex-direction: column-reverse; overflow-y: auto; max-height: 470px;">
                                <div wire:poll='mountdata'>
                                    @if (filled($allmessages))
                                        @foreach ($allmessages as $msg)
                                            <div
                                                @if ($msg->user_id == auth()->id()) class="d-flex flex-row justify-content-end" @else class="d-flex flex-row justify-content-start" @endif>
                                                @if ($msg->user_id != auth()->id())
                                                    @if ($sender->photo != '' || $sender->photo != null)
                                                        <img src="{{ asset('storage/' . $sender->photo) }}"
                                                            alt="avatar 1" class=" img rounded-circle ms-3 "
                                                            style="width: 45px; height: 100%;">
                                                    @else
                                                        <img src="../assets/images/user.png" alt="avatar 1"
                                                            class="ms-3 " style="width: 45px; height: 100%;">
                                                    @endif
                                                @endif
                                                <div>
                                                    <p class="small p-2 ms-3 mb-1 rounded-3"
                                                        @if ($msg->user_id == auth()->id()) style="background-color: #f5f6f7;" @else style="background-color: #5C6BC0;  color:white" @endif>
                                                        {{ $msg->message }}
                                                    </p>
                                                    <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                                                        @if ($msg->created_at->isToday())
                                                            {{ $msg->created_at->format('H:i') }}
                                                        @else
                                                            {{ $msg->created_at->format('d/m/Y - H:i') }}
                                                        @endif

                                                        @if ($msg->user_id == auth()->id())
                                                            @if ($msg->is_seen == 0)
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                                              </svg>
                                                            @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                                                <path style="color:blue" d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
                                                              </svg>
                                                            @endif
                                                        @endif
                                                    </p>

                                                </div>
                                                @if ($msg->user_id == auth()->id())
                                                    @if ($msg->user->photo != '' || $msg->user->photo != null)
                                                        <img src="{{ asset('storage/' . $msg->user->photo) }}"
                                                            alt="avatar 1" class=" img rounded-circle ms-3 "
                                                            style="width: 45px; height: 100%;">
                                                    @else
                                                        <img src="../assets/images/user.png" alt="avatar 1"
                                                            class="ms-3 " style="width: 45px; height: 100%;">
                                                    @endif
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                            @if (auth()->user()->photo != '' || auth()->user()->photo != null)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="rounded-circle me-3"
                                    alt="avatar 3" style="width: 40px; height: 100%;">
                            @else
                                <img src="../assets/images/user.png" class="me-3" alt="avatar 3"
                                    style="width: 40px; height: 100%;">
                            @endif
                            <form wire:submit.prevent="SendMessage" style="display: flex; width: 100%;">
                                <input wire:model="message" type="text" class="form-control form-control-lg"
                                    id="exampleFormControlInput2" placeholder="Message">
                                <button type="submit"
                                    class="ms-3 btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height:40px;  background-color: #3949AB;">
                                    <svg style="margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" width="15"
                                        height="15" fill="currentColor" class="bi bi-send-fill"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
