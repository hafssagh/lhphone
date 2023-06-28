<div class="row">
    <form wire:submit.prevent="addNewSale()">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h4 class="card-title">Formulaire de création d'une nouvelle vente</h4>
                    <label class="text-end float-end" wire:click.prevent='goToListeSales()'>X</label>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5>
                            <svg xmlns="http://www.w4.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                                <path
                                    d="M4.54.146A.5.5 0 0 1 4.894 0h6.214a.5.5 0 0 1 .454.146l4.494 4.494a.5.5 0 0 1 .146.454v6.214a.5.5 0 0 1-.146.454l-4.494 4.494a.5.5 0 0 1-.454.146H4.894a.5.5 0 0 1-.454-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.894a.5.5 0 0 1 .146-.454L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z" />
                                <path
                                    d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.45 4.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                            </svg>
                            &nbsp; Erreurs
                        </h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif <br>
                <div class="row">
                    <div class="col-md-6"><br>
                        @can('agent')
                            <div class="form-group row mb-1">
                                <label for="name" class="col-sm-2 col-form-label">Agent</label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="{{ userName() }}" class="form-control" disabled>
                                </div>
                            </div>
                        @endcan
                        @canAny(['manager', 'superadmin'])
                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label">Agent <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <div class="col-sm-8">
                                    <select wire:model="newSale.user"
                                        class="form-control bg-white text-black @error('newSale.user') is-invalid @enderror"
                                        id="user">
                                        <option value=""></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->last_name }} {{ $user->first_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endcanAny
                        <div class="form-group row mb-1">
                            <label for="name_client" class="col-sm-2 col-form-label">Société <span
                                    class="text-danger"><strong>*</strong></span> </label>
                            <div class="col-sm-8">
                                <select wire:model="newSale.name_client"
                                    class="form-control bg-white text-black @error('newSale.name_client') is-invalid @enderror"
                                    id="name_client">
                                    <option value=""></option>
                                    @foreach ($mails as $mail)
                                        <option value="{{ $mail->company }}">
                                            {{ $mail->company }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-sm-2 col-form-label" style="font-size: 0.8rem;">Qantité <span
                                    class="text-danger"><strong>*</strong></span></label>
                            <div class="col-sm-8">
                                <input type="number" wire:model="newSale.quantity"
                                    class="form-control
                        @error('newSale.quantity') is-invalid @enderror">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="card-description">
                            Détails commande
                          </p>
                        <div class="form-group">
                            <div style="display: flex;">
                                <div class="col-md-6">
                                    <div style="display: flex; flex-direction: column;">
                                        <div class="form-group"
                                            style="margin-bottom: 0; display: flex; align-items: center;">
                                            <label class="col-sm-2">10w:</label>
                                            <div class="col-sm-8">
                                                <input
                                                    class="form-control detail @error('newSale.un') is-invalid @enderror"
                                                    wire:model="newSale.un" type="number" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group"
                                            style="margin-bottom: 0; display: flex; align-items: center;">
                                            <label class="col-sm-2">20w:</label>
                                            <div class="col-sm-8">
                                                <input
                                                    class="form-control detail @error('newSale.deux') is-invalid @enderror"
                                                    wire:model="newSale.deux" type="number" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group"
                                            style="margin-bottom: 0; display: flex; align-items: center;">
                                            <label class="col-sm-2">30w:</label>
                                            <div class="col-sm-8">
                                                <input
                                                    class="form-control detail @error('newSale.trois') is-invalid @enderror"
                                                    wire:model="newSale.trois" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group"
                                            style="margin-bottom: 0; display: flex; align-items: center;">
                                            <label class="col-sm-2">50w:</label>
                                            <div class="col-sm-8">
                                                <input
                                                    class="form-control detail @error('newSale.cinq') is-invalid @enderror"
                                                    wire:model="newSale.cinq" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group"
                                            style="margin-bottom: 0; display: flex; align-items: center;">
                                            <label class="col-sm-2">100w:</label>
                                            <div class="col-sm-8">
                                                <input
                                                    class="form-control detail @error('newSale.dix') is-invalid @enderror"
                                                    wire:model="newSale.dix" type="number">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; flex-direction: column;">
                                    <div class="form-group"
                                        style="margin-bottom: 0; display: flex; align-items: center;">
                                        <label class="col-sm-4">Hublots:</label>
                                        <div class="col-sm-8">
                                            <input
                                                class="form-control detail @error('newSale.hublots') is-invalid @enderror"
                                                wire:model="newSale.hublots" type="number">
                                        </div>
                                    </div>
                                    <div class="form-group"
                                        style="margin-bottom: 0; display: flex; align-items: center;">
                                        <label class="col-sm-4">Pommeaux:</label>
                                        <div class="col-sm-8">
                                            <input
                                                class="form-control detail @error('newSale.pommeaux') is-invalid @enderror"
                                                wire:model="newSale.pommeaux" type="number">
                                        </div>
                                    </div>
                                    <div class="form-group"
                                        style="margin-bottom: 0; display: flex; align-items: center;">
                                        <label class="col-sm-4">Mousseurs:</label>
                                        <div class="col-sm-8">
                                            <input
                                                class="form-control detail @error('newSale.mousseurs') is-invalid @enderror"
                                                wire:model="newSale.mousseurs" type="number">
                                        </div>
                                    </div>
                                    <div class="form-group"
                                        style="margin-bottom: 0; display: flex; align-items: center;">
                                        <label class="col-sm-4">Réglettes:</label>
                                        <div class="col-sm-8">
                                            <input
                                                class="form-control detail @error('newSale.reglette') is-invalid @enderror"
                                                wire:model="newSale.reglette" type="number" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group"
                                        style="margin-bottom: 0; display: flex; align-items: center;">
                                        <label class="col-sm-4">Spot picket:</label>
                                        <div class="col-sm-8">
                                            <input
                                                class="form-control detail @error('newSale.spot') is-invalid @enderror"
                                                wire:model="newSale.spot" type="number" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group"
                                        style="margin-bottom: 0; display: flex; align-items: center;">
                                        <label class="col-sm-4">Tubes:</label>
                                        <div class="col-sm-8">
                                            <input
                                                class="form-control detail @error('newSale.tube') is-invalid @enderror"
                                                wire:model="newSale.tube" type="number" disabled>
                                        </div>
                                    </div>
                                </div>

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
                        Enregistrer</button>&nbsp;
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </form>


</div>
