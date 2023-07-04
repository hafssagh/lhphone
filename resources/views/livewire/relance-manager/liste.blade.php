<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Mails de relance <br>
                    <a href="/mailR" style="font-weight: normal; font-size:14px">
                        Mails de relances des agents
                    </a>
                </h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddMailRelance"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Nouveau mail de relance</button>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    @cannot('manager')
                        <th>Manager</th>
                    @endcannot
                    <th> Société</th>
                    <th>Client</th>
                    <th>Coordonnées</th>
                    <th class="text-center">No devis</th>
                    <th class="text-center">Date d'envoi devis</th>
                    <th class="text-center">Objet du devis</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($relances as $relance)
                    <tr>
                        @cannot('manager')
                            <td style="padding: 0.6rem; ">
                                &nbsp;&nbsp; {{ $relance->users->first_name }}</td>
                        @endcannot
                        <td style="padding: 0.6rem;"><strong style="color: rgb(65, 118, 170)">&nbsp;&nbsp;
                                {{ $relance->company }}</strong></td>
                        <td>
                            <p class="text-dark fw-bold" style="margin-bottom: 0;">{{ $relance->nameClient }}</p>
                        </td>
                        <td style="padding: 0.6rem;">
                            <p class="text-muted" style="margin-bottom: 0;">
                                <span class="text-dark">Email</span>: {{ $relance->emailClient }} &nbsp;
                                <span class="text-dark">No</span>: {{ $relance->numClient }}
                            </p>
                        </td>
                        <td style="padding: 0.6rem;">
                            <p class="text-dark fw-bold text-center" style="margin-bottom: 0;">{{ $relance->numDevie }}
                            </p>
                        </td>
                        <td style="padding: 0.6rem;">
                            <p class="text-center" style="margin-bottom: 0;">
                                {{ $relance->date_envoie }}</p>
                        </td>
                        <td style="padding: 0.6rem;" class="text-center text-muted">
                            {{ $relance->object }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-end">
            {{ $relances->links() }}
        </div>
    </div>
</div>
