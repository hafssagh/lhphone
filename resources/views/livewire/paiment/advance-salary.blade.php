<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des avancements de salaire</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="toggleShowAddForm"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Ajouter </button>
            </div>
        </div><br>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Agent</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">Cause</th>
                        <th class="text-center">Ajouté</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($isAddAdvance)
                        <tr>
                            <form action="">
                                <td class="text-center" style="padding: 0.8rem;">
                                    <select wire:model="newAdvance.user" 
                                    class="form-control bg-white text-black @error('newAdvance.user') is-invalid @enderror">
                                        <option value=""></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->last_name }} {{ $user->first_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 0.8rem;" > <input class="form-control @error('newAdvance.advance') is-invalid @enderror"
                                    type="text" wire:model="newAdvance.advance"
                                       wire:keydown.enter='addNewAdvance'> 
                               </td>
                                <td style="padding: 0.8rem;" > <input class="form-control @error('newAdvance.motif') is-invalid @enderror"
                                     type="text" wire:model="newAdvance.motif"
                                        wire:keydown.enter='addNewAdvance'> 
                                </td>
                                <td style="padding: 0.8rem;"></td>
                                <td class="text-center" style="padding: 0.8rem;">
                                    <button wire:click.prevent='addNewAdvance'
                                        class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                        </svg>
                                        &nbsp; Valider</button>
                                    <button wire:click="toggleShowAddForm"
                                        class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                            <path
                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                        </svg>
                                        Annuler</button>
                                </td>
                            </form>
                        </tr>
                    @endif
                    @foreach ($avances as $avance)
                        <tr>
                            <td style="padding: 0.8rem;" class="text-center"> {{ $avance->users->last_name }} {{ $avance->users->first_name }}</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $avance->advance }} DH</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $avance->motif }}</td>
                            <td class="text-center" style="padding: 0.8rem;">
                                {{ $avance->users->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
               {{ $avances->links() }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        
    </div>
</div>