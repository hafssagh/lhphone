<div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Formulaire d'édition départ</h3>
                        <label class="text-end float-end" wire:click.prevent='goToListe()'>X</label>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Agent</label>
                            <div class="col-sm-9">
                                <select wire:model="editResignation.user_id" class="form-control bg-white text-black">
                                    <option value="{{ $editResignation['user_id'] }}">
                                        {{ $editResignation['users']['first_name'] }}
                                        {{ $editResignation['users']['last_name'] }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date de départ</label>
                            <div class="col-sm-9">
                                <input type="date" wire:model="editResignation.date"
                                    class="form-control @error('editResignation.date') is-invalid @enderror">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Le motif de départ</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('editResignation.motive') is-invalid @enderror"
                                    type="text" wire:model="editResignation.motive">
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button wire:click.prevent='updateResignation' type="submit" class="btn btn-lg text-black mb-0 me-0 justify-content-end"
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
</div>
