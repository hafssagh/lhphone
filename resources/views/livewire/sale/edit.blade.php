<div class="row">
    <form wire:submit.prevent="updateSale()">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h3 class="card-title">Formulaire d'édition d'une vente</h3>
                    <label class="text-end float-end" wire:click.prevent='goToListeSales()'>X</label>
                </div>
                <!-- form fields for step 3 -->

                <div class="row">
                    <div class="col-md-6">
                        <p class="card-subtitle card-subtitle-dash">Agent</p>
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <select wire:model="editSale.user_id" class="form-control bg-white text-black">
                                <option value="{{ $editSale['user_id'] }}">
                                    {{ $editSale['users']['first_name'] }}
                                    {{ $editSale['users']['last_name'] }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantité</label>
                            <input type="number" wire:model="editSale.quantity"
                                class="form-control
                        @error('editSale.quantity') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="card-subtitle card-subtitle-dash">Société</p>
                        <div class="form-group">
                            <label for="name_client">Nom complet</label>
                            <input type="text"
                                class="form-control @error('editSale.name_client') is-invalid @enderror"
                                wire:model="editSale.name_client">
                        </div>
                        <div class="form-group">
                            <label>Adresse Email</label>
                            <input type="text" wire:model="editSale.mail_client"
                                class="form-control @error('editSale.mail_client') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="phone_client">No de téléphone</label>
                            <input type="text" wire:model="editSale.phone_client"
                                class="form-control @error('editSale.phone_client') is-invalid @enderror">
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
