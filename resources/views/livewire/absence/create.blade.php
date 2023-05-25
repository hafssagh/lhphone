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
                <select wire:model="newAbsence.user"
                    class="form-control bg-white text-black @error('newAbsence.user') is-invalid @enderror">
                    <option value=""></option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }}
                            {{ $user->last_name }}</option>
                    @endforeach
                </select>
                @error('newAbsence.user')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Date d'absence</label>
            <div class="col-sm-9">
                <input type="date" wire:model="newAbsence.date"
                    class="form-control @error('newAbsence.date') is-invalid @enderror">
                @error('newAbsence.date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Heure d'absence</label>
            <div class="col-sm-9">
                <input class="form-control @error('newAbsence.abs_hours') is-invalid @enderror" type="number"
                    wire:model="newAbsence.abs_hours">
                @error('newAbsence.abs_hours')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Justification</label>
            <div class="col-sm-9">
                <textarea class="form-control @error('newAbsence.justification') is-invalid @enderror"
                    wire:model="newAbsence.justification" id="floatingTextarea2" style="height: 80px">
                </textarea>
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <button wire:click.prevent='addNewAbsence' type="submit"
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
