<div class="card">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <h3 class="card-title">Formulaire d'ajout d'un congé</h3>
            <label class="text-end float-end" wire:click.prevent='goToListeConge'>X</label>
        </div>
        <br>
        <div class="form-group row">
            <label class="col-sm-3 ">Agent <span class="text-danger"><strong>*</strong></span> </label>
            <div class="col-sm-8">
                @foreach ($users as $utilisateur)
                    <label>
                        <input type="checkbox" wire:model="utilisateurs.{{ $utilisateur->id }}">
                        {{ $utilisateur->last_name }} {{ $utilisateur->first_name }}
                    </label>
                @endforeach
                @error('utilisateurs')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Date<span class="text-danger"><strong>*</strong></span></label>
            <div class="col-sm-4">
                <label>De</label>
                <div class="col-sm-12">
                    <input class="form-control @error('dateDebut') is-invalid @enderror" type="date"
                        wire:model="dateDebut">
                    @error('dateDebut')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <label>À</label>
                <div class="col-sm-12">
                    <input class="form-control @error('dateFin') is-invalid @enderror" type="date"
                        wire:model="dateFin">
                    @error('dateFin')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Statut</label>
            <div class="col-sm-8">
                <select class="form-control" wire:model="statut">
                    <option value="">------------</option>
                    <option value="1">Payé</option>
                    <option value="2">Non payé</option>
                </select>
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <button wire:click.prevent='ajouterConges' type="submit"
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
