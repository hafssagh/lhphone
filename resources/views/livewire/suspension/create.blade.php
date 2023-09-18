<div class="card">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <h3 class="card-title">Formulaire d'ajout d'une suspension</h3>
            <label class="text-end float-end" wire:click.prevent='goToListeSuspension'>X</label>
        </div>
        <br>
        <div class="form-group row">
            <label class="col-sm-3 ">Agent <span class="text-danger"><strong>*</strong></span> </label>
            <div class="col-sm-8">
                <select wire:model="newSuspension.user"
                    class="form-control bg-white text-black @error('newSuspension.user') is-invalid @enderror">
                    <option value=""></option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->last_name }} {{ $user->first_name }}</option>
                    @endforeach
                </select>
                @error('newSuspension.user')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Date<span class="text-danger"><strong>*</strong></span></label>
            <div class="col-sm-4">
                <label>Arrêt</label>
                <div class="col-sm-12">
                    <input class="form-control @error('newSuspension.date_debut') is-invalid @enderror" type="date"
                        wire:model="newSuspension.date_debut">
                    @error('newSuspension.date_debut')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <label>Retour</label>
                <div class="col-sm-12">
                    <input class="form-control @error('newSuspension.date_fin') is-invalid @enderror" type="date"
                        wire:model="newSuspension.date_fin">
                    @error('newSuspension.date_fin')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Cause</label>
            <div class="col-sm-8">
                <textarea class="form-control @error('newSuspension.cause') is-invalid @enderror" wire:model="newSuspension.cause"
                    id="floatingTextarea2" style="height: 80px">
                </textarea>
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <button wire:click.prevent='addNewSuspension' type="submit"
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
