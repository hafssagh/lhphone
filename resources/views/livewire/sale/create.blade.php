<div class="row">
    <form wire:submit.prevent="addNewSale()">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h3 class="card-title">Formulaire de création d'une nouvelle vente</h3>
                    <label class="text-end float-end" wire:click.prevent='goToListeSales()'>X</label>
                </div>
                <!-- form fields for step 3 -->

                   @if ($errors->any())
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
                @endif 
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-subtitle card-subtitle-dash">Agent</p>
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <input type="text" placeholder="{{ userName() }}" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantité</label>
                            <input type="number" wire:model="newSale.quantity"
                                class="form-control
                        @error('newSale.quantity') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="remark">Remarque</label>
                            <div class="form-floating">
                                <textarea class="form-control @error('newSale.remark') is-invalid @enderror" wire:model="newSale.remark"
                                    id="floatingTextarea2" style="height: 100px">
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <p class="card-subtitle card-subtitle-dash">Société</p>
                        <div class="form-group">
                            <label for="name_client">Nom complet</label>
                            <input type="text"
                                class="form-control @error('newSale.name_client') is-invalid @enderror"
                                wire:model="newSale.name_client">
                        </div>
                        <div class="form-group">
                            <label>Adresse Email</label>
                            <input type="text" wire:model="newSale.mail_client"
                                class="form-control @error('newSale.mail_client') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="phone_client">No de téléphone</label>
                            <input type="text" wire:model="newSale.phone_client"
                                class="form-control @error('newSale.phone_client') is-invalid @enderror">
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
