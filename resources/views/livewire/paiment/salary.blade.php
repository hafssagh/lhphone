<div class="row">
    <div class="card card-rounded">
        <div class="card-body">
            <div class="d-sm-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title card-title-dash">Liste des salaires</h4><br>
                </div>
                <div>
                    <a class="btn btn-lg text-black mb-0 me-0 float-end" href="/advance-salary"
                        style="font-size: 14px; line-height: 18px; padding: 8px; display: inline-block;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg>
                        &nbsp;Ajouter un avancement de salaire
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control" wire:model.debounce.250ms='search'
                            placeholder="Rechercher ...">
                        <span class="input-group-text"><i class="icon-search"></i></span>
                    </div>
                </div>
                @cannot('manager')
                    <div class="col-md-3">
                        <form wire:submit.prevent="render">
                            <select class="form-select" wire:model="selectedCompany" id="selectedCompany"
                                style="font-size:12px">
                                <option value="all">Société</option>
                                <option value="lh">LH Phone</option>
                                <option value="h2f">H2F Premium</option>
                            </select>
                        </form>
                    </div>
                @endcannot
            </div>
            <div class="table">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Salarié</th>
                            <th class="text-center">Salaire de base</th>
                            <th class="text-center">Salaire par jour</th>
                            <th class="text-center">Mode de paiement</th>
                            <th class="text-center">
                                Rib
                                <button type="submit" class="btn btn-sm text-black mb-0 me-0" style="margin-left:-15px"
                                    wire:click="toggleRibDisplay">
                                    <i style="color:rgb(223, 51, 51); font-size:12px">(Afficher)</i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salary as $salaries)
                            <tr>
                                <td style="padding: 0.6rem;" class="text-center">{{ $salaries->last_name }}
                                    {{ $salaries->first_name }}</td>
                                <td style="padding: 0.6rem;" class="text-center">
                                    {{ $salaries->base_salary }} DH</td>
                                <td style="padding: 0.6rem;" class="text-center">
                                    <span style="font-weight: 900;">{{ $salaries->salary }} DH</span>
                                </td>
                                <td style="padding: 0.6rem;" class="text-center">
                                    @if ($salaries->type_virement == 'virement')
                                        <div class="badge badge-outline-success paie2" style="color:#aaa8a8;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                                fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"
                                                style="color : #F95F53; margin-bottom:2px">
                                                <circle cx="8" cy="8" r="8" />
                                            </svg>
                                            &nbsp; Virement
                                        </div>
                                    @else
                                        <div class="badge badge-outline-success paie" style="color:#4DA761;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                                fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"
                                                style="color : #4DA761;  margin-bottom:2px ">
                                                <circle cx="8" cy="8" r="8" />
                                            </svg>
                                            &nbsp; Espèce&nbsp; &nbsp;
                                        </div>
                                    @endif
                                </td>
                                <td style="padding: 0.6rem;" class="text-center">
                                    @if ($showRib)
                                        {{ $salaries->rib }}
                                    @else
                                        ************************
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-end">
                    {{ $salary->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
