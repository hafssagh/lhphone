<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h4 class="card-title">Changer le mot de passe</h4>
                    {{-- <label class="text-end float-end" wire:click.prevent=''>X</label> --}}
                </div><br><br>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label class="col-form-label">Mot de passe actuel</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control" maxlength="25" type="password" wire:model="current_password">
                        @error('current_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        @if($error1)
                        <p class="text-danger">{{ $error1 }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label class="col-form-label">Nouveau mot de passe</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control" maxlength="25" type="password" wire:model="new_password">
                        @error('new_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label class="col-form-label">Confirmation du mot de passe</label>
                    </div>
                    <div class="col-lg-8">
                        <input class="form-control" maxlength="20" type="password" wire:model="confirmation_password">
                        @if($error)
                        <p class="text-danger">{{ $error }}</p>
                        @endif
                        @error('confirmation_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div> 
                <div class="d-flex flex-row-reverse">
                    <button type="submit" wire:click="updatePassword"
                        class="btn btn-lg text-black mb-0 me-0 justify-content-end"
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
    </div>
</div>


<script>
    window.addEventListener('showSuccessMessage', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast: 'success',
            title: event.detail.message || "Opération effectuée avec succès",
            showConfirmButton: false,
            timer: 3000
        })
    });
</script>