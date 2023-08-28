<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des congés</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddconge()"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Ajouter un congé</button>
            </div>
        </div><br>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom Complet</th>
                        <th class="text-center">Date début</th>
                        <th class="text-center">Date fin</th>
                        <th class="text-center">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupedConges = $conges->groupBy(function ($conge) {
                            return $conge->date_debut . '-' . $conge->date_fin;
                        });
                    @endphp

                    @foreach ($groupedConges as $groupedConge)
                        @php
                            $firstConge = $groupedConge->first();
                        @endphp
                        <tr>
                            <td style="padding: 0.7rem;">
                                <strong>{{ $firstConge->users->last_name }}
                                    {{ $firstConge->users->first_name }}</strong>
                                @foreach ($groupedConge as $conge)
                                    @if ($conge !== $firstConge)
                                        <br><br>
                                        <strong>{{ $conge->users->last_name }} {{ $conge->users->first_name }}</strong>
                                    @endif
                                @endforeach
                            </td>
                            <td style="padding: 0.7rem;" class="text-center">
                                {{ $firstConge->date_debut }}
                            </td>
                            <td style="padding: 0.7rem;" class="text-center">
                                {{ $firstConge->date_fin }}
                            </td>
                            <td style="padding: 0.7rem;" class="text-center">
                                @if ($firstConge->statut == 1)
                                    <div class="badge badge-outline-success paie" style="color:#4DA761;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                            fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"
                                            style="color : #4DA761;  margin-bottom:2px ">
                                            <circle cx="8" cy="8" r="8"></circle>
                                        </svg>
                                        &nbsp; &nbsp;&nbsp;&nbsp; Payé&nbsp; &nbsp;&nbsp; &nbsp;
                                    </div>
                                @elseif ($firstConge->statut == 2)
                                    <div class="badge badge-outline-success paie2" style="color:#aaa8a8;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                            fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"
                                            style="color : #F95F53; margin-bottom:2px">
                                            <circle cx="8" cy="8" r="8"></circle>
                                        </svg>
                                        &nbsp; Non payé
                                    </div>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
