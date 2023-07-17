 <div class="card card-rounded">
     <div class="card-body">
         <div class="d-sm-flex justify-content-between align-items-start">
             <div>
                 <h4 class="card-title card-title-dash">Propositions de la semaine</h4>
             </div>

             <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                 <a href="{{ route('mail') }}" class="btn btn-outline-dark"
                     style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Jour</a>
                 <div class="btn-group" role="group">
                     <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                         aria-expanded="false"
                         style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">
                         Tous
                     </button>
                     <ul class="dropdown-menu" style="font-size: 13px" wire:model="selectedMonth" id="selectedMonth">
                         <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', 'all')">Tous</a>
                         </li>
                         <li><a class="dropdown-item" href="#"
                                 wire:click="$set('selectedMonth', '01')">Janvier</a>
                         </li>
                         <li><a class="dropdown-item" href="#"
                                 wire:click="$set('selectedMonth', '02')">Février</a>
                         </li>
                         <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '03')">Mars</a>
                         </li>
                         <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '04')">Avril</a>
                         </li>
                         <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '05')">Mai</a>
                         </li>
                         <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '06')">Juin</a>
                         </li>
                         <li><a class="dropdown-item" href="#"
                                 wire:click="$set('selectedMonth', '07')">Juillet</a>
                         </li>
                         <li><a class="dropdown-item" href="#" wire:click="$set('selectedMonth', '08')">Août</a>
                         </li>
                         <li><a class="dropdown-item" href="#"
                                 wire:click="$set('selectedMonth', '10')">Octobre</a>
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
                     <option value="all">Tous les statuts</option>
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
                         <th>Date d'envoi</th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($proposition as $propo)
                         <tr>
                             <td style="padding: 0.6rem;"><button wire:click="goToEditMail({{ $propo->id }})"
                                     style="border:none; background-color:white">
                                     @if ($propo->state == '0')
                                         <div class="square_table" style="background-color: #c9c6c6;">
                                         @elseif($propo->state == '1')
                                             <div class="square_table" style="background-color: #84cc88;">
                                             @elseif($propo->state == '-1')
                                                 <div class="square_table" style="background-color: #f5a7a1;">
                                                 @elseif($propo->state == '3')
                                                     <div class="square_table" style="background-color: #f3ea6c;">
                                     @endif
                                 </button> </td>
                             @cannot('agent')
                                 <td style="padding: 0.6rem;">
                                     {{ $propo->users->first_name }}</td>
                             @endcannot
                             <td style="padding: 0.6rem;"><strong
                                     style="color: rgb(65, 118, 170)">{{ $propo->company }}</strong></td>
                             <td style="padding: 0.6rem;">
                                 <p class="text-dark fw-bold" style="margin-bottom: 0;">{{ $propo->nameClient }}</p>
                                 <p class="text-muted" style="margin-bottom: 0;">
                                     <span class="text-dark">Email</span>: {{ $propo->emailClient }} &nbsp;
                                     <span class="text-dark">No</span>: {{ $propo->numClient }}
                                 </p>
                             </td>
                             <td style="padding: 0.6rem;">
                                 @if ($propo->state == '-1')
                                     <div class="badge badge-opacity-danger" style="background-color: #fedfdd;">
                                         Refusée
                                     </div>
                                 @elseif ($propo->state == '1')
                                     <div class="badge badge-opacity-success" style="background-color: #c8e6c9;">
                                         Acceptée
                                     </div>
                                 @elseif ($propo->state == '0')
                                     <div class="badge badge-opacity-dark" style="background-color: #cccccc;">
                                         Non traitée
                                     </div>
                                 @elseif ($propo->state == '3')
                                     <div class="badge badge-opacity-warning" style="background-color: #ffff8fdc;">
                                         Rappeler
                                     </div>
                                 @endif
                             </td>
                             <td style="padding: 0.6rem;">
                                 <p class="text-dark fw-bold" style="margin-bottom: 0;">{{ $propo->created_at->format('d-m-Y H:i:s') }}
                                </p>
                                 @if ($propo->rappel != null)
                                     <p class="text-danger" style="margin-bottom: 0;">
                                         <span class="text-dark">Rappel</span> : {{ $propo->rappel }}
                                     </p>
                                 @endif
                             </td>
                             <td>
                                <span>
                                     @if ($propo->send == 'rive')
                                         <span class=" vertical-text2 text-primary"><strong> Eco<br> Rive</strong>
                                         </span>
                                     @elseif ($propo->send == 's2ee')
                                         <span class=" vertical-text2 text-success"><strong>s2ee</strong>
                                         </span>
                                     @endif
                                 </span>
                            </td>
                         </tr>
                     @endforeach
                 </tbody>
             </table>
             <div class="float-end">
                 {{ $proposition->onEachSide(1)->links() }}
             </div>
         </div>
     </div>
 </div>
