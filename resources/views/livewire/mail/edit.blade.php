<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h4 class="card-title">Modifier une proposition</h4>
                    <label class="text-end float-end" wire:click.prevent='goToListPropos'>X</label>
                </div>
                <form wire:submit.prevent="updateMail()">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div><br><br>
                                <span> <strong class="title">Agent :</strong> {{ $editMail['users']['first_name'] }}
                                    {{ $editMail['users']['last_name'] }}</span> <br>
                                <strong class="title">Société :</strong> <span
                                    class="text" >{{ $editMail['company'] }}</span><br>
                                <strong class="title">Responsable :</strong> <span
                                    class="text">{{ $editMail['nameClient'] }}</span><br>
                                <strong class="title">No de téléphone :</strong> <span
                                    class="text">{{ $editMail['numClient'] }}</span> <br>
                                <strong class="title">Adresse Email :</strong> <span
                                    class="text">{{ $editMail['emailClient'] }}</span> <br>
                                <strong class="title">Adresse :</strong> <span
                                    class="text">{{ $editMail['adresse'] }}</span>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="remark">Remarque</label>
                                <textarea class="form-control" wire:model="editMail.remark" wire:keydown.enter.prevent="updateMail" class="form-control" style="height: 100px">
                            </textarea>
                                @error('editMail.remark')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rappel">Rappel</label>
                                <input type="datetime-local"  class="form-control" wire:model="editMail.rappel" wire:keydown.enter.prevent="updateMail" class="form-control">
                            </div>
                        </div>
                        @cannot('agent')
                        <div class="d-flex flex-row-reverse">
                            <div>
                                <span class="svg-icon svg-icon-md" wire:click="Rappeler">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                                      </svg>
                                </span>&nbsp;&nbsp;
                                <span class="svg-icon svg-icon-md" wire:click="PropoAccepter">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-check-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                        <path
                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z" />
                                    </svg>
                                </span> &nbsp;&nbsp;
                                <span class="svg-icon svg-icon-md" wire:click="PropoRefuse">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-x-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        @endcannot
                </form>
            </div>
        </div>
    </div>
</div>
