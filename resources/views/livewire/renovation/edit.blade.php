<div class="row">
    <form wire:submit.prevent="updateRenovation()">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h3 class="card-title">Formulaire d'édition d'un rendez-vous </h3>
                    <label class="text-end float-end" wire:click.prevent='goToListeRenovation()'>X</label>
                </div>
                <!-- form fields for step 3 -->


                <div class="row">
                    <div class="col-md-6">
                        @cannot('agent')
                            <br><br>
                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label" style="font-size: 0.8rem;">Statut</label>
                                <div class="col-sm-10">
                                    @if ($editRenovation['state'] == 'rapp' || $editRenovation['state'] == 'annuler')
                                        <select wire:model="editRenovation.state"
                                            class="form-control @error('editRenovation.state') is-invalid @enderror">
                                            <option value="">-----</option>
                                            <option value="0">RDV pris</option>
                                            <option value="annuler">RDV non pris</option>
                                        </select>
                                    @else
                                        <select wire:model="editRenovation.state"
                                            class="form-control @error('editRenovation.state') is-invalid @enderror">
                                            <option value="">-----</option>
                                            <option value="0">RDV pris</option>
                                            <option value="1">Confirmé</option>
                                            <option value="2">A voir</option>
                                            <option value="3">NRP</option>
                                            <option value="4">Injoingnable</option>
                                            <option value="-1">Annulé</option>
                                            <option value="-2">Hors cible</option>
                                            <option value="-3">Mauvaise fois</option>
                                        </select>
                                    @endif

                                </div>
                            </div>
                        @endcannot

                        @can('agent')
                            <br><br>
                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label" style="font-size: 0.8rem;">Statut</label>
                                <div class="col-sm-10">
                                    <select wire:model="editRenovation.state"
                                        class="form-control @error('editRenovation.state') is-invalid @enderror">
                                        <option value="">-----</option>
                                        <option value="rapp">Rappel</option>
                                        <option value="0">RDV pris</option>
                                        <option value="annuler">RDV non pris</option>
                                    </select>
                                </div>
                            </div>
                        @endcan

                        <div class="table-container">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Agent</strong></td>
                                        <td style="padding: 0.5rem;">{{ $editRenovation['users']['first_name'] }}
                                            {{ $editRenovation['users']['last_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Prospect</strong></td>
                                        <td style="padding: 0.5rem;">{{ $editRenovation['prospect'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Département</strong>
                                        </td>
                                        <td style="padding: 0.5rem;">{{ $editRenovation['dep'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Adresse</strong>
                                        </td>
                                        <td style="padding: 0.5rem;">{{ $editRenovation['adresse'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">No mobile</strong>
                                        </td>
                                        <td style="padding: 0.5rem;">{{ $editRenovation['num_mobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">No fixe</strong>
                                        </td>
                                        <td style="padding: 0.5rem;">{{ $editRenovation['num_fix'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Email</strong>
                                        </td>
                                        <td style="padding: 0.5rem;">{{ $editRenovation['email'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Date rendez-vous</strong>
                                        </td>
                                        <td style="padding: 0.1rem;">
                                            <input type="date" wire:model="editRenovation.date_rdv"
                                                class="form-control details @error('editRenovation.date_rdv') is-invalid @enderror"
                                                style="border: none;"
                                                placeholder="{{ date('d-m-Y', strtotime($editRenovation['date_rdv'])) }}">
                                            <input type="time" wire:model="editRenovation.cr"
                                                class="form-control details @error('editRenovation.cr') is-invalid @enderror"
                                                style="border: none;"
                                                placeholder=" {{ date('H:i', strtotime($editRenovation['cr'])) }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @cannot('agent')
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top:85px">
                            @endcannot
                            @can('agent')
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-top:85px">
                                    @endcan
                                    <label for="commentaire">Commentaire</label>
                                    <textarea class="form-control" wire:model="editRenovation.commentaire" class="form-control" style="height: 120px">  </textarea>
                                </div>
                                @can('agent')
                                    <div class="form-group">
                                        <label for="name">Retour Manager</label>
                                        <input type="text" wire:model="editRenovation.retour" class="form-control"
                                            disabled>
                                    </div>
                                @endcan
                                @cannot('agent')
                                    <div class="form-group">
                                        <label for="name">Retour Manager</label>
                                        <input type="text" wire:model="editRenovation.retour" class="form-control">
                                    </div>
                                @endcan
                                <div class="form-group">
                                    <label for="name">Rappel</span></label>
                                    <input type="datetime-local" wire:model="editRenovation.rappel"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
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

                    </div>
                </div>
                <!-- /.card-body -->
    </form>
</div>
