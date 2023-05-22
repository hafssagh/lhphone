<div class="card">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <h3 class="card-title">Formulaire d'ajout d'une absence</h3>
            <label class="text-end float-end" wire:click.prevent='goToListeAbsence'>X</label>
        </div>
        <br>
        <div class="form-group row">
            <label class="col-sm-3 ">Agent</label>
            <div class="col-sm-9">
                <select wire:model="editAbsence.user_id" class="form-control bg-white text-black">
                    <option value="{{ $editAbsence['user_id'] }}">
                        {{ $editAbsence['users']['first_name'] }}
                        {{ $editAbsence['users']['last_name'] }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Date d'absence</label>
            <div class="col-sm-9">
                <input type="date" wire:model="editAbsence.date"
                    class="form-control @error('editAbsence.date') is-invalid @enderror">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Heure d'absence</label>
            <div class="col-sm-9">
                <input class="form-control @error('editAbsence.abs_hours') is-invalid @enderror" type="number"
                    wire:model="editAbsence.abs_hours">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Justification</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('editAbsence.justification') is-invalid @enderror"
                    wire:model="editAbsence.justification">
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <button wire:click.prevent='updateAbsence' type="submit"
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
