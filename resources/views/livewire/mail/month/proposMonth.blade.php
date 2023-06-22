<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Toutes les propositions</h4><br>
            </div>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a href="{{ route('mail') }}" class="btn btn-outline-dark"
                    style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Jour</a>
                <a href="{{ route('mailWeek') }}" class="btn btn-outline-dark"
                    style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Semaine</a>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">
                        Mois
                    </button>
                    <ul class="dropdown-menu" style="font-size: 13px" wire:model="selectedMonth" id="selectedMonth">
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', 'all')">Tous</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '01')">Janvier</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '02')">Février</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '03')">Mars</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '04')">Avril</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '05')">Mai</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '06')">Juin</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '07')">Juillet</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '08')">Août</a>
                        </li>
                        <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '10')">Octobre</a>
                        </li>
                        <li><a class="dropdown-item" href="#"
                                wire:click="$set('selectedMonth', '11')">Novembre</a></li>
                        <li><a class="dropdown-item" href="#"
                                wire:click="$set('selectedMonth', '12')">Décembre</a></li>
                    </ul>
                </div>
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
                    <option value="all">Tous les staturs</option>
                    <option value="1">Acceptée</option>
                    <option value="-1">Refusée</option>
                    <option value="3">À rappeler</option>
                    <option value="0">Non traitée</option>
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
                        <th>Société</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Date </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Allproposition as $Allpropo)
                        <tr>
                            <td style="padding: 0.6rem;"><button wire:click="goToEditMail({{ $Allpropo->id }})"
                                    style="border:none; background-color:white">
                                    @if ($Allpropo->state == '0')
                                        <div class="square_table" style="background-color: #c9c6c6;">
                                        @elseif($Allpropo->state == '1')
                                            <div class="square_table" style="background-color: #84cc88;">
                                            @elseif($Allpropo->state == '-1')
                                                <div class="square_table" style="background-color: #f5a7a1;">
                                                @elseif($Allpropo->state == '3')
                                                    <div class="square_table" style="background-color: #f3ea6c;">
                                    @endif
                                </button>
                            </td>
                            @cannot('agent')
                                <td style="padding: 0.6rem;"> {{ $Allpropo->users->last_name }}
                                    {{ $Allpropo->users->first_name }}</td>
                            @endcannot
                            <td style="padding: 0.6rem;"><strong
                                    style="color: rgb(65, 118, 170)">{{ $Allpropo->company }}</strong></td>
                            <td style="padding: 0.6rem;">
                                <p class="text-dark fw-bold" style="margin-bottom: 0;">{{ $Allpropo->nameClient }}</p>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">Email</span>: {{ $Allpropo->emailClient }} &nbsp;
                                    <span class="text-dark">No</span>: {{ $Allpropo->numClient }}
                                </p>
                            </td>
                            <td style="padding: 0.6rem;">
                                @if ($Allpropo->state == '-1')
                                    <div class="badge badge-opacity-danger" style="background-color: #fedfdd;">
                                        Refusée
                                    </div>
                                @elseif ($Allpropo->state == '1')
                                    <div class="badge badge-opacity-success" style="background-color: #c8e6c9;">
                                        Acceptée
                                    </div>
                                @elseif ($Allpropo->state == '0')
                                    <div class="badge badge-opacity-dark" style="background-color: #cccccc;">
                                        Non traitée
                                    </div>
                                @elseif ($Allpropo->state == '3')
                                    <div class="badge badge-opacity-warning" style="background-color: #ffff8fdc;">
                                        Rappeler
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 0.6rem;">{{ $Allpropo->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $Allproposition->links() }}
            </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>