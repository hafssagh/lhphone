<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des agents suspendus</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddSuspension()"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Nouvelle suspension</button>
            </div>
        </div><br>
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <p class="mb-0"></p>
                </div>
                <ul class="bullet-line-list">
                    @foreach ($suspensions as $suspension)
                        <li>
                            <div class="d-flex justify-content-between">
                                <div> <strong class="text-dark">{{ $suspension->users->last_name }}
                                        {{ $suspension->users->first_name }} &nbsp;</strong>
                                    suspendu(e) du &nbsp; <a class="alert-link" style="color:#772e28">
                                        {{ $suspension->date_debut }} </a>
                                    &nbsp; jusqu'au &nbsp; <a class="alert-link" style="color:#772e28">
                                        {{ $suspension->date_fin }} </a></div>
                                <p>{{ \Carbon\Carbon::parse($suspension->created_at)->diffForHumans() }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="list align-items-center pt-3">
                    <div class="wrapper w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
