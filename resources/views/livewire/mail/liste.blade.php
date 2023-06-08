<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des propositions</h4><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.debounce.250ms='search' placeholder="Rechercher ...">
                            <span class="input-group-text"><i class="icon-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-dark btn-sm active">Jour</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm text-dark">Semaine</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm text-dark">Mois</button>
                        </div>
                    </div>
                </div>
            </div>
    
            @can('agent')
                <div>
                    <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddPropos"
                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg>
                        &nbsp; Nouvelle proposition</button>
                </div>
            @endcan
        </div><br>
        <div class="table">
            <table class="table">
                <thead>
                    <tr>
                        @cannot('agent')
                            <th>Agent</th>
                        @endcannot
                        <th class="text-center">Client</th>
                        <th class="text-center">Adresse Email</th>
                        <th class="text-center">Numéro de téléphone</th>
                        <th class="text-center">Date/Heure d'envoie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposition as $propo)
                        <tr>
                            <td style="padding: 0.8rem;"> {{ $propo->users->last_name }}
                                {{ $propo->users->first_name }}</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $propo->nameClient }}</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $propo->emailClient }}</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $propo->numClient }}</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $propo->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $proposition->links() }}
            </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>
