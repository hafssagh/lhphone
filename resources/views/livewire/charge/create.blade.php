<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h4 class="card-title">Formulaire d'ajout</h4>
                    <label class="text-end float-end" wire:click.prevent='goToListeCharges'>X</label>
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
                <form wire:submit.prevent="addNewCharge">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Charge <span class="text-danger"><strong>*</strong></span></label>
                                <input type="text" wire:model="newCharges.object" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Prix <span class="text-danger"><strong>*</strong></span></label>
                                <input type="number" wire:model="newCharges.price" class="form-control">
                            </div>
                           {{--  <div class="form-group">
                                <label for="name">Société <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <select  class="form-control bg-white text-dark" wire:model="newCharges.company">
                                <option value="">---------</option>
                                <option value="lh">LH Phone</option>
                                <option value="h2f">H2F Premium</option>
                            </select>
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="name">Fichier</label>
                                    <input type="file" wire:model="newCharges.file" class="form-control">
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
