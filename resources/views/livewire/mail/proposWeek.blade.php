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
                             <td style="padding: 0.6rem;"><button data-toggle="modal"
                                     data-target="#exampleModal{{ $propo->id }}" style="border:none; background-color:white">
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
                                 <td style="padding: 0.6rem;"> {{ $propo->users->last_name }}
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
                             <td style="padding: 0.6rem;">{{ $propo->adresse }}</td>
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

 @foreach ($proposition as $propo)
     <div class="modal fade" id="exampleModal{{ $propo->id }}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content" style='width:600px'>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">{{ $propo->company }}</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body" style="display: flex; justify-content: center; align-items: center; ">
                     <div>
                         <strong class="title">Responsable:</strong> <span
                             class="text">{{ $propo->nameClient }}</span>
                         <br>
                         <strong class="title">No de téléphone:</strong> <span
                             class="text">{{ $propo->numClient }}</span> <br>
                         <strong class="title">Adresse Email:</strong> <span
                             class="text">{{ $propo->emailClient }}</span> <br>
                         <strong class="title">Adresse:</strong> <span class="text">{{ $propo->adresse }}</span>
                         <br>
                         @if ($propo->remark != null)
                             <strong class="title">Remarque:</strong> <span class="text">{{ $propo->remark }}</span>
                             <br>
                         @endif
                     </div>
                 </div>
                 @cannot('agent')
                     @if ($propo->state == '0')
                         <div class="modal-footer">
                             <div class="square">
                                 <button class="btn btn-sm" wire:click="mailValide({{ $propo->id }}, '3')">
                                     <strong>Rappeler</strong>
                                 </button>
                             </div>
                             <span class="svg-icon svg-icon-md" wire:click="mailValide({{ $propo->id }}, '1')">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                     class="bi bi-check-square" viewBox="0 0 16 16">
                                     <path
                                         d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                     <path
                                         d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z" />
                                 </svg>
                             </span> &nbsp;
                             <span class="svg-icon svg-icon-md" wire:click="mailValide({{ $propo->id }}, '-1')">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                     <path
                                         d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                     <path
                                         d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                 </svg>
                             </span>
                         </div>
                     @endif
                 @endcannot
             </div>
         </div>
     </div>
 @endforeach
