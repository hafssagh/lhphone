 <div class="card card-rounded">
     <div class="card-body">
         <div class="d-sm-flex justify-content-between align-items-start">
             <div>
                 <h4 class="card-title card-title-dash">Propositions de la semaine</h4><br>
                 <div class="input-group">
                     <input type="text" class="form-control" wire:model.debounce.250ms='search'
                         placeholder="Rechercher ...">
                     <span class="input-group-text"><i class="icon-search"></i></span>
                 </div>
             </div>
             <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                 <button type="button" class="btn btn-outline-dark" wire:click="goToListPropos"
                     style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Jour</button>
                 <button type="button" class="btn btn-outline-dark" wire:click="goToPropMonth"
                     style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Mois</button>
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
                     @foreach ($proposition as $propo)
                         <tr>
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
