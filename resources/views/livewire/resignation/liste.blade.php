<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des départs</h4><br>
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
                    &nbsp;Nouveau départ</button>
            </div>
        </div><br>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Agent</th>
                        <th class="text-center">Date de départ</th>
                        <th class="text-center">Motif de départ</th>
                        <th class="text-center">Ajouté</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($isAddResignation)
                        <tr>
                            <form action="">
                                <td class="text-center" style="padding: 0.4rem;">
                                    <select wire:model="newResignation.user" 
                                    class="form-control bg-white text-black @error('newResignation.user') is-invalid @enderror">
                                        <option value=""></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->last_name }} {{ $user->first_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td style="padding: 0.4rem;" > <input class="form-control @error('newResignation.motive') is-invalid @enderror"
                                     type="text" wire:model="newResignation.motive"
                                        wire:keydown.enter='addNewResignation'> 
                                </td>
                                <td style="padding: 0.4rem;"></td>
                                <td class="text-center" style="padding: 0.4rem;">
                                    <button wire:click.prevent='addNewResignation'
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
                    @foreach ($resignations as $resignation)
                        <tr>
                            <td style="padding: 0.4rem;" class="text-center"> {{ $resignation->users->last_name }} {{ $resignation->users->first_name }}</td>
                            <td class="text-center" style="padding: 0.4rem;">{{ $resignation->date }}</td>
                            <td class="text-center" style="padding: 0.4rem;">{{ $resignation->motive }}</td>
                            <td class="text-center" style="padding: 0.4rem;">
                                {{ \Carbon\Carbon::parse($resignation->users->created_at)->diffForHumans($resignation->users->date_contract) }}
                            </td>
                            <td class="text-center" style="padding: 0.4rem;">
                                <a href="javascript:;" class="btn btn-sm btn-icon" wire:click="editResignation({{$resignation->id}})">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg>
                                    </span>
                                </a>
                                <a href="javascript:;" wire:click="confirmDelete({{ $resignation->id }})" class="btn btn-sm btn-icon">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                        </svg>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $resignations->links() }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        
    </div>
</div>
