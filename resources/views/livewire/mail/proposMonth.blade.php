<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Toutes les propositions</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <button type="button" class="btn btn-outline-dark" wire:click="goToListPropos"
                    style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Jour</button>
                <button type="button" class="btn btn-outline-dark" wire:click="goToPropWeek"
                    style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Semaine</button>
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
        <div class="table">
            <table class="table">
                <thead>
                    <tr>
                        @cannot('agent')
                            <th>Agent</th>
                        @endcannot
                        <th>Société</th>
                        <th>Client</th>
                        <th>Adresse</th>
                        <th>Date/Heure d'envoie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Allproposition as $Allpropo)
                        <tr>
                            @cannot('agent')
                                <td style="padding: 0.6rem;"> {{ $Allpropo->users->last_name }}
                                    {{ $Allpropo->users->first_name }}</td>
                            @endcannot
                            <td style="padding: 0.6rem;"><strong style="color: rgb(65, 118, 170)">{{ $Allpropo->company }}</strong></td>
                            <td style="padding: 0.6rem;">
                               <p class="text-dark fw-bold" style="margin-bottom: 0;">{{ $Allpropo->nameClient }}</p>
                               <p class="text-muted" style="margin-bottom: 0;">
                                   <span class="text-dark">Email</span>: {{ $Allpropo->emailClient }} &nbsp;
                                   <span class="text-dark">No</span>: {{ $Allpropo->numClient }}
                               </p>
                           </td>
                           <td style="padding: 0.6rem;">{{ $Allpropo->adresse}}</td>
                           <td style="padding: 0.6rem;">{{ $Allpropo->created_at }}</td>
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
