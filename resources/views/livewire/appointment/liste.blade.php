<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des rendez-vous</h4>
            </div>

            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddAppointment"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Nouveau rendez-vous</button>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" wire:model="selectedStatus" wire:change="render" style="font-size: 13px">
                    <option value="all">Tous les RDV</option>
                    <option value="0">En attente</option>
                    <option value="1">Confirmé</option>
                    <option value="2">A voir</option>
                    <option value="3">NRP</option>
                    <option value="4">Injoingnable</option>
                    <option value="5">Enregistrement demandé</option>
                    <option value="6">Présence couple</option>
                    <option value="-1">Annulé</option>
                    <option value="-2">Hors cible</option>
                    <option value="-3">Mauvaise fois</option>
                </select>
            </div>
        </div><br>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        @cannot('agent')
                            <th>Agent</th>
                        @endcannot
                        <th class="text-center">Date prise</th>
                        <th>Prospect</th>
                        <th>Détails</th>
                        <th class="text-center">Dep.</th>
                        <th class="text-center">Date rendez-vous</th>
                        <th>Statut</th>
                        <th class="text-center">Date de confirm.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointment as $appoint)
                        <tr>
                            <td style="padding: 0.6rem;"><button wire:click="editAppointment({{ $appoint->id }})"
                                    style="border:none; background-color:white">
                                    @if ($appoint->state == '0')
                                        <div class="square_table" style="background-color: #c9c6c6;">
                                        @elseif($appoint->state == '1')
                                            <div class="square_table" style="background-color: #84cc88;">
                                            @elseif($appoint->state == '2')
                                                <div class="square_table" style="background-color: #a8ecee;">
                                                @elseif($appoint->state == '3')
                                                    <div class="square_table" style="background-color: #f3ea6c;">
                                                    @elseif($appoint->state == '4')
                                                        <div class="square_table" style="background-color: #b09dd4;">
                                                        @elseif($appoint->state == '5')
                                                            <div class="square_table"
                                                                style="background-color: #a78671;">
                                                            @elseif($appoint->state == '6')
                                                                <div class="square_table"
                                                                    style="background-color: #a6b5df;">
                                                                @elseif($appoint->state == '-1')
                                                                    <div class="square_table"
                                                                        style="background-color: #f5a7a1;">
                                                                    @elseif($appoint->state == '-2')
                                                                        <div class="square_table"
                                                                            style="background-color: #eec08b;">
                                                                        @elseif($appoint->state == '-3')
                                                                            <div class="square_table"
                                                                                style="background-color: #c58c91 ;">
                                    @endif
                                </button> </td>
                            @cannot('agent')
                                <td style="padding: 0.6rem;">
                                    {{ $appoint->users->first_name }}</td>
                            @endcannot
                            <td style="padding: 0.6rem;">
                                <p class="text-dark fw-bold text-center" style="margin-bottom: 0;">
                                    {{ \Carbon\Carbon::parse($appoint->date_prise)->format('d-m-Y') }}
                                </p>
                            </td>
                            <td style="padding: 0.6rem;"><strong
                                    style="color: rgb(65, 118, 170)">{{ $appoint->prospect }}</strong></td>
                            <td style="padding: 0.6rem;">
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">No fixe</span>: {{ $appoint->num_fix }} <br>
                                    <span class="text-dark">No mobile</span>: {{ $appoint->num_mobile }}
                                </p>
                            </td>
                            <td style="padding: 0.6rem;" class="text-center"><strong>{{ $appoint->dep }}</strong></td>
                            <td style="padding: 0.6rem;">
                                <p class="text-dark fw-bold text-center" style="margin-bottom: 0;">
                                    {{ \Carbon\Carbon::parse($appoint->date_rdv)->format('d-m-Y') }}
                                    {{ \Carbon\Carbon::parse($appoint->cr)->format('H:i') }}
                                </p>
                            </td>
                            <td class="text-center" style="padding: 0.6rem;">
                                @if ($appoint->state == '-1')
                                    <div class="badge badge-opacity-danger" style="background-color: #fedfdd;">
                                        Annulé
                                    </div>
                                @elseif ($appoint->state == '-2')
                                    <div class="badge badge-opacity-danger" style="background-color: #fad9b3;">
                                        Hors cible
                                    </div>
                                @elseif ($appoint->state == '-3')
                                    <div class="badge badge-opacity-dark"
                                        style="background-color: #f8d1d1; color: #6e0b14 ">
                                        Mauvaise fois
                                    </div>
                                @elseif ($appoint->state == '1')
                                    <div class="badge badge-opacity-success" style="background-color: #bbdfbc;">
                                        Confirmé
                                    </div>
                                @elseif ($appoint->state == '2')
                                    <div class="badge badge-opacity-success" style="background-color: #d3f5f7;">
                                        A voir
                                    </div>
                                @elseif ($appoint->state == '0')
                                    <div class="badge badge-opacity-dark" style="background-color: #cccccc;">
                                        En attente
                                    </div>
                                @elseif ($appoint->state == '3')
                                    <div class="badge badge-opacity-warning" style="background-color: #ffff8fdc;">
                                        NRP
                                    </div>
                                @elseif ($appoint->state == '4')
                                    <div class="badge badge-opacity-"
                                        style="background-color: #d9cdf3; color:#75609c">
                                        Injoignable
                                    </div>
                                @elseif ($appoint->state == '5')
                                    <div class="badge badge-opacity-dark"
                                        style="background-color: #d8c5af; color:#6F4E37">
                                        Enregistrement demandé
                                    </div>
                                @elseif ($appoint->state == '6')
                                    <div class="badge badge-opacity-primary">
                                        Présence couple
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 0.6rem;" class="text-center">
                                @if (
                                    $appoint->state == '0' ||
                                        $appoint->state == '2' ||
                                        $appoint->state == '3' ||
                                        $appoint->state == '4' ||
                                        $appoint->state == '5' ||
                                        $appoint->state == '6')
                                    <div class="spinner-border text-dark" role="status"
                                        style="width:16px ;height:16px">
                                        <span class="sr-only"></span>
                                    </div>
                                @elseif($appoint->state == '1' || $appoint->state == '-1' || $appoint->state == '-2' || $appoint->state == '-3')
                                    {{ \Carbon\Carbon::parse($appoint->date_confirm)->format('d-m-Y') }}
                                @else
                                    {{ $appoint->updated_at->format('d-m-Y') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $appointment->onEachSide(1)->links() }} 
            </div>
        </div>
    </div>
</div>