<div class="row">
    <form wire:submit.prevent="updateUser()">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h3 class="card-title">Formulaire d'édition utilisateur</h3>
                    <label class="text-end float-end" wire:click.prevent='goToListeUser()'>X</label>
                </div><br>
                <!-- form fields for step 3 -->

      {{--           @if ($errors->any())
                <div class="alert alert-danger">
                    <h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                        <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                      </svg>
                      &nbsp; Erreurs</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="last_name">Nom</label>
                                    <input type="text" wire:model="editUser.last_name"
                                        class="form-control
                                @error('editUser.last_name') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="first_name">Prénom</label>
                                    <input type="text" wire:model="editUser.first_name"
                                        class="form-control 
                                @error('editUser.first_name') is-invalid @enderror">

                                    {{-- @error('editUser.first_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="id_card">Numéro piéce d'identité</label>
                                    <input type="text" wire:model="editUser.id_card"
                                        class="form-control
                                @error('editUser.id_card') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="birthday">Date de naissance</label>
                                    <input type="date" wire:model="editUser.birthday"
                                        class="form-control  @error('editUser.birthday') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">No de téléphone</label>
                            <input type="text" wire:model="editUser.phone"
                                class="form-control
                        @error('editUser.phone') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="email">Adresse Email</label>
                            <input type="email" wire:model="editUser.email"
                                class="form-control
                        @error('editUser.email') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_contract">Date du contrat</label>
                            <input type="date"
                                class="form-control @error('editUser.date_contract') is-invalid @enderror"
                                wire:model="editUser.date_contract">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Type du contrat</label>
                                    <select
                                        class="form-control bg-white text-dark @error('editUser.type_contract') is-invalid @enderror"
                                        wire:model="editUser.type_contract">
                                        <option value="">---------</option>
                                        <option value="CDI">CDI</option>
                                        <option value="CDD">CDD</option>
                                        <option value="temp">Travail temporaire</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="duration_contract">Durée du contrat</label>
                                    <input type="text" wire:model="editUser.duration_contract" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Société</label>
                                    <select class="form-control bg-white text-dark" id="select1"
                                        @error('editUser.company') is-invalid @enderror wire:model="newUser.company">
                                        <option value="">---------</option>
                                        <option value="lh">LH Phone</option>
                                        <option value="h2f">H2F Primium</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Groupe</label>
                                    <select class="form-control text-dark" id="select2"
                                        @if (!$additionalOptionEnabled) disabled @endif
                                        @error('editUser.group') is-invalid @enderror wire:model="newUser.group">
                                        <option value="">---------</option>
                                        <option value="1">Equipe Chris Ezzahra</option>
                                        <option value="2">Equipe Amine</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="duration_contract">Salaire brute</label>
                            <div class="input-group mb-3">
                                <input type="text" wire:model="editUser.base_salary"
                                    class="form-control @error('editUser.base_salary') is-invalid @enderror">
                                <span class="input-group-text">DH</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path
                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                        </svg>
                        Enregistrer
                    </button>
                    <button type="submit" class="btn btn-secondary btn-lg text-black mb-0 me-0 justify-content-end"
                        wire:click.prevent="confirmPwdReset"
                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                          </svg>
                            Réinitialiser le mot de passe
                    </button>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </form>
</div>
