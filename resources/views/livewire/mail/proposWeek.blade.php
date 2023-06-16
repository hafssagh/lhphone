 <div class="card card-rounded">
     <div class="card-body">
         <div class="d-sm-flex justify-content-between align-items-start">
             <div>
                 <h4 class="card-title card-title-dash">Propositions de la semaine</h4>
             </div>
             
             <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                 <button type="button" class="btn btn-outline-dark" wire:click="goToListPropos"
                     style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Jour</button>
                 <button type="button" class="btn btn-outline-dark" wire:click="goToPropMonth"
                     style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Mois</button>
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
                    <option value="all">Tous les status</option>
                    <option value="1">Accepté</option>
                    <option value="-1">Refusé</option>
                    <option value="3">A rappeler</option>
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
                         <th>Adresse</th>
                         <th>Date d'envoie</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($proposition as $propo)
                         <tr>
                            <td style="padding: 0.6rem;" >
                                @if ($propo->state == '0')
                                    <div class="square_table" style="background-color: #c9c6c6;">
                                @elseif($propo->state == '1')
                                    <div class="square_table" style="background-color: #84cc88;">
                                @elseif($propo->state == '-1')
                                    <div class="square_table" style="background-color: #f5a7a1;">
                                @elseif($propo->state == '3')
                                    <div class="square_table" style="background-color: #f3ea6c;">
                                @endif
                            </td>
                             @cannot('agent')
                                 <td style="padding: 0.6rem;"> {{ $propo->users->last_name }}
                                     {{ $propo->users->first_name }}</td>
                             @endcannot
                             <td style="padding: 0.6rem;"><strong style="color: rgb(65, 118, 170)">{{ $propo->company }}</strong></td>
                             <td style="padding: 0.6rem;">
                                <p class="text-dark fw-bold" style="margin-bottom: 0;">{{ $propo->nameClient }}</p>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">Email</span>: {{ $propo->emailClient }} &nbsp;
                                    <span class="text-dark">No</span>: {{ $propo->numClient }}
                                </p>
                            </td>
                            <td style="padding: 0.6rem;">{{ $propo->adresse}}</td>
                            <td style="padding: 0.6rem;">{{ $propo->created_at }}</td>
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
