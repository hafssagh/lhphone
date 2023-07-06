<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h4 class="card-title">Modifier une proposition
                        @if ($editMail['send'] == 'rive')
                            <span style="font-size:15px" class="text-primary"><strong>&nbsp; RiveEco</strong>
                            </span>
                        @elseif ($editMail['send'] == 's2ee')
                            <span style="font-size:15px" class="text-success"><strong>&nbsp; s2ee</strong>
                            </span>
                        @endif
                    </h4>
                    <label class="text-end float-end" wire:click.prevent='goToListPropos'>X</label>
                </div>
                <form wire:submit.prevent="updateMail()">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <br>
                            @cannot('agent')
                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label" style="font-size: 0.8rem;">Statut</label>
                                    <div class="col-sm-10">
                                        <select wire:model="editMail.state"
                                            class="form-control @error('editMail.state') is-invalid @enderror">
                                            <option value="">-----</option>
                                            <option value="0">Non traitée</option>
                                            <option value="1">Acceptée</option>
                                            <option value="-1">Refusée</option>
                                            <option value="3">Rappeler</option>
                                        </select>
                                    </div>
                                </div>
                            @endcannot
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Agent</strong></td>
                                        <td style="padding: 0.5rem;">{{ $editMail['users']['first_name'] }}
                                            {{ $editMail['users']['last_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Société</strong></td>
                                        <td style="padding: 0.5rem;">{{ $editMail['company'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Responsable</strong></td>
                                        <td style="padding: 0.5rem;">{{ $editMail['nameClient'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">No de téléphone</strong>
                                        </td>
                                        <td style="padding: 0.5rem;">{{ $editMail['numClient'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Adresse Email</strong></td>
                                        <td style="padding: 0.5rem;">{{ $editMail['emailClient'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.5rem;"><strong class="title">Adresse</strong></td>
                                        <td
                                            style="padding: 0.5rem; max-width: 35px; word-wrap: break-word; white-space: normal;">
                                            {{ $editMail['adresse'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <br>
                            @cannot('agent')
                                <br><br><br>
                            @endcannot
                            <div class="form-group" style='margin-top:-10px'>
                                <label for="remark">Remarque</label>
                                <textarea class="form-control" wire:model="editMail.remark" wire:keydown.enter.prevent="updateMail" class="form-control"
                                    style="height: 100px">
                            </textarea>
                                @error('editMail.remark')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rappel">Rappel</label>
                                <input type="datetime-local" class="form-control" wire:model="editMail.rappel"
                                    wire:keydown.enter.prevent="updateMail" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button type="submit" class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                Enregistrer</button>&nbsp;
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
