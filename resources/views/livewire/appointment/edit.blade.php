 <div class="row">
     <form wire:submit.prevent="updateAppointment()">
         <div class="card">
             <div class="card-body">
                 <div class="d-sm-flex justify-content-between align-items-start">
                     <h3 class="card-title">Formulaire d'édition d'un rendez-vous </h3>
                     <label class="text-end float-end" wire:click.prevent='goToListeAppointments()'>X</label>
                 </div>
                 <!-- form fields for step 3 -->


                 <div class="row">
                     <div class="col-md-6">
                         @cannot('agent')
                         <br><br>
                             <div class="form-group row mb-1">
                                 <label class="col-sm-2 col-form-label" style="font-size: 0.8rem;">Statut</label>
                                 <div class="col-sm-10">
                                     <select wire:model="editAppointment.state"
                                         class="form-control @error('editAppointment.state') is-invalid @enderror">
                                         <option value="">-----</option>
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
                             </div>
                         @endcannot

                         @can('agent')
                             <br><br>
                         @endcan

                         <div class="table-container">
                             <table class="table table-bordered">
                                 <tbody>
                                     <tr>
                                         <td style="padding: 0.5rem;"><strong class="title">Agent</strong></td>
                                         <td style="padding: 0.5rem;">{{ $editAppointment['users']['first_name'] }}
                                             {{ $editAppointment['users']['last_name'] }}</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 0.5rem;"><strong class="title">Prospect</strong></td>
                                         <td style="padding: 0.5rem;">{{ $editAppointment['prospect'] }}</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 0.5rem;"><strong class="title">Département</strong>
                                         </td>
                                         <td style="padding: 0.5rem;">{{ $editAppointment['dep'] }}</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 0.5rem;"><strong class="title">Adresse</strong>
                                         </td>
                                         <td style="padding: 0.5rem;">{{ $editAppointment['adresse'] }}</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 0.5rem;"><strong class="title">No mobile</strong>
                                         </td>
                                         <td style="padding: 0.5rem;">{{ $editAppointment['num_mobile'] }}</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 0.5rem;"><strong class="title">No fixe</strong>
                                         </td>
                                         <td style="padding: 0.5rem;">{{ $editAppointment['num_fix'] }}</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 0.5rem;"><strong class="title">Date rendez-vous</strong>
                                         </td>
                                         <td style="padding: 0.1rem;">
                                             <input type="date" wire:model="editAppointment.date_rdv"
                                                 class="form-control details @error('editAppointment.date_rdv') is-invalid @enderror"
                                                 style="border: none;"
                                                 placeholder="{{ date('d-m-Y', strtotime($editAppointment['date_rdv'])) }}">
                                             <input type="time" wire:model="editAppointment.cr"
                                                 class="form-control details @error('editAppointment.cr') is-invalid @enderror"
                                                 style="border: none;"
                                                 placeholder=" {{ date('H:i', strtotime($editAppointment['cr'])) }}">
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                         </div>

                     </div>
                     @cannot('agent')
                         <div class="col-md-6">
                             <div class="form-group" style="margin-top:55px">
                             @endcannot
                             @can('agent')
                                 <div class="col-md-6">
                                     <div class="form-group" style="margin-top:35px">
                                     @endcan
                                     <label for="commentaire">Commentaire</label>
                                     <textarea class="form-control" wire:model="editAppointment.commentaire" class="form-control" style="height: 120px">  </textarea>
                                 </div>

                                 <div class="form-group">
                                     <label for="name">Retour </label>
                                     <input type="text" wire:model="editAppointment.retour" class="form-control">
                                 </div>
                             </div>
                         </div>
                         @cannot('agent')
                             <div class="d-flex flex-row-reverse">
                                 <button type="submit" class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                                     style="font-size: 14px; line-height: 18px; padding: 8px;">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                         <path
                                             d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                     </svg>
                                     Enregistrer</button>&nbsp;
                             </div>
                         @endcannot

                     </div>
                 </div>
                 <!-- /.card-body -->
     </form>
 </div>
