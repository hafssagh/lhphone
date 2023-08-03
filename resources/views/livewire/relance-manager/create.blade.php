<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h4 class="card-title">Envoyer un mail de relance</h4>
                    <label class="text-end float-end" wire:click.prevent='goToListMail'>X</label>
                </div><br>
                <form wire:submit.prevent="sendEmail">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Objet du mail <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <input type="text" wire:model="subject" class="form-control">
                                @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Société <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <input type="text" wire:model="company" class="form-control">
                                @error('company')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Adresse Email <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <input type="email" wire:model="email" class="form-control">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">No de téléphone</label>
                                <input type="text" wire:model="numClient" class="form-control">
                                @error('numClient')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nom complet client</label>
                                <input type="text" wire:model="nameClient" class="form-control">
                                @error('nameClient')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">No du devis <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <input type="text" wire:model="numDevie" class="form-control">
                                @error('numDevie')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Date d'envoi du devis <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <input type="date" wire:model="date_envoie" class="form-control">
                                @error('date_envoie')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Objet du devis <span
                                        class="text-danger"><strong>*</strong></span></label>
                                <input type="text" wire:model="object" class="form-control">
                                @error('object')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
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
