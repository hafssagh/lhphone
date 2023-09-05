<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h4 class="card-title">Formulaire d'ajout un rendez-vous</h4>
                    <label class="text-end float-end" wire:click.prevent='goToListeRenovation'>X</label>
                </div><br>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                                <path
                                    d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z" />
                                <path
                                    d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                            </svg>
                            &nbsp; Erreurs
                        </h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form wire:submit.prevent="addNewRenovation">
                    <div class="form-group row">
                        <div class="col-md-6">
                            @canAny(['manager', 'superadmin'])
                                <div class="form-group">
                                    <label>Agent <span class="text-danger"><strong>*</strong></span></label>
                                    <select wire:model="newRenovation.user"
                                        class="form-control bg-white text-black @error('newRenovation.user') is-invalid @enderror"
                                        id="user">
                                        <option value=""></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->last_name }} {{ $user->first_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcanAny
                            <div class="form-group">
                                <label for="name">Nom complet prospect <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <input type="text" wire:model="newRenovation.prospect" class="form-control">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Dép. <span
                                                class="text-danger"><strong>*</strong></span></label>
                                        <input type="text" wire:model="newRenovation.dep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="name">Adresse <span
                                                class="text-danger"><strong>*</strong></span></label>
                                        <input type="text" wire:model="newRenovation.adresse" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" style="margin-top: -25px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">No fixe </label>
                                        <input type="text" wire:model="newRenovation.num_fix" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">No mobile </label>
                                        <input type="text" wire:model="newRenovation.num_mobile"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" style="margin-top: -25px;">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Date rendez-vous</label>
                                        <input type="date" wire:model="newRenovation.date_rdv" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Créneau </label>
                                        <input type="time" wire:model="newRenovation.cr" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="commentaire">Commentaire</label>
                                <textarea class="form-control" wire:model="newRenovation.commentaire" class="form-control" style="height: 120px">
                            </textarea>
                            </div>
                            @cannot('agent')
                            <div class="form-group">
                                <label for="name">Retour </label>
                                <input type="text" wire:model="newRenovation.retour" class="form-control">
                            </div>
                            @endcannot
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Statut <span
                                                class="text-danger"><strong>*</strong></span></label>
                                                <select wire:model="newRenovation.state"
                                                class="form-control @error('newRenovation.state') is-invalid @enderror">
                                                <option value="">-----</option>
                                                <option value="0">RDV pris</option>
                                                <option value="rapp">Rappel</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Rappel</span></label>
                                        <input type="datetime-local" wire:model="newRenovation.rappel" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button type="submit" class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                    <path
                                        d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                </svg>
                                &nbsp;Envoyé</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
