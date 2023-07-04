<div class="row">
    <form wire:submit.prevent="updateSale()">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    @can('agent')
                        <h3 class="card-title">Formulaire de vente </h3>
                    @endcan
                    @canAny(['superadmin', 'manager'])
                        <h3 class="card-title">Formulaire d'édition d'une vente </h3>
                    @endcanAny
                    <label class="text-end float-end" wire:click.prevent='goToListeSales()'>X</label>
                </div>
                <!-- form fields for step 3 -->
                <br><br>
                <div class="md-stepper-horizontal ">
                    <div class="md-step active">
                        <div class="md-step-circle"><span>1</span></div>
                        <div class="md-step-title">Propo envoyée</div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>
                    <div class="md-step active">
                        <div class="md-step-circle"><span>2</span></div>
                        <div class="md-step-title">Cmd confirmée</div>
                        {{-- <div class="md-step-optional">Optional</div> --}}
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>
                    @if ($editSale['state'] == '3' || $editSale['state'] == '1' || $editSale['state'] == '-1' )
                        <div class="md-step active">
                        @else
                            <div class="md-step">
                    @endif
                    <div class="md-step-circle"><span>3</span></div>
                    <div class="md-step-title">Devis envoyé</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>

                @if ($editSale['state'] == '1')
                    <div class="md-step active">
                    @else
                        <div class="md-step">
                @endif
                <div class="md-step-circle"><span>4</span></div>
                <div class="md-step-title">Devis signé</div>
                <div class="md-step-bar-left"></div>
                <div class="md-step-bar-right"></div>
            </div>
            <div class="md-step">
                <div class="md-step-circle"><span>5</span></div>
                <div class="md-step-title">En attent. livraison</div>
                <div class="md-step-bar-left"></div>
                <div class="md-step-bar-right"></div>
            </div>
            <div class="md-step">
                <div class="md-step-circle"><span>6</span></div>
                <div class="md-step-title">Livré</div>
                <div class="md-step-bar-left"></div>
                <div class="md-step-bar-right"></div>
            </div>
            <div class="md-step">
                <div class="md-step-circle"><span>7</span></div>
                <div class="md-step-title">AH envoyé</div>
                <div class="md-step-bar-left"></div>
                <div class="md-step-bar-right"></div>
            </div>
            <div class="md-step">
                <div class="md-step-circle"><span>6</span></div>
                <div class="md-step-title">AH signé</div>
                <div class="md-step-bar-left"></div>
                <div class="md-step-bar-right"></div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                @cannot('agent')
                    <div class="form-group row mb-1">
                        <label class="col-sm-2 col-form-label" style="font-size: 0.8rem;">Statut</label>
                        <div class="col-sm-10">
                            <select wire:model="editSale.state"
                                class="form-control @error('editSale.state') is-invalid @enderror">
                                <option value="">-----</option>
                                <option value="3">Devis envoyé</option>
                                <option value="1">Devis signé</option>
                                <option value="-1">Devis refusé</option>
                                <option value="">Livré</option>
                                <option value="">AH envoyé</option>
                                <option value="">AH signé</option>
                            </select>
                        </div>
                    </div>
                @endcannot

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="padding: 0.5rem;"><strong class="title">Agent</strong></td>
                            <td style="padding: 0.5rem;">{{ $editSale['users']['first_name'] }}
                                {{ $editSale['users']['last_name'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem;"><strong class="title">Société</strong></td>
                            <td style="padding: 0.5rem;">{{ $editSale['name_client'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem;"><strong class="title">No de téléphone</strong></td>
                            <td style="padding: 0.5rem;">{{ $editSale['phone_client'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem;"><strong class="title">Adresse Email</strong></td>
                            <td style="padding: 0.5rem;">{{ $editSale['mail_client'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem;"><strong class="title">Quantité</strong></td>
                            <td style="padding: 0.1rem;">
                                <input type="number" wire:model="editSale.quantity"
                                    class="form-control details @error('editSale.quantity') is-invalid @enderror"
                                    style="border: none;" placeholder="{{ $editSale['quantity'] }}">
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="col-md-6">
                @cannot('agent')
                    <br><br><br>
                @endcannot
                <div class="form-group">
                    <div style="display: flex;">
                        <div class="col-md-6">
                            <div style="display: flex; flex-direction: column;">
                                <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                    <label class="col-sm-2">10w:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control detail @error('editSale.un') is-invalid @enderror"
                                            wire:model="editSale.un" type="number" {{-- disabled --}}>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                    <label class="col-sm-2">20w:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control detail @error('editSale.deux') is-invalid @enderror"
                                            wire:model="editSale.deux" type="number" {{-- disabled --}}>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                    <label class="col-sm-2">30w:</label>
                                    <div class="col-sm-8">
                                        <input
                                            class="form-control detail @error('editSale.trois') is-invalid @enderror"
                                            wire:model="editSale.trois" type="number">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                    <label class="col-sm-2">50w:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control detail @error('editSale.cinq') is-invalid @enderror"
                                            wire:model="editSale.cinq" type="number">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                    <label class="col-sm-2">100w:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control detail @error('editSale.dix') is-invalid @enderror"
                                            wire:model="editSale.dix" type="number">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column;">
                            <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                <label class="col-sm-4">Hublots:</label>
                                <div class="col-sm-8">
                                    <input class="form-control detail @error('editSale.hublots') is-invalid @enderror"
                                        wire:model="editSale.hublots" type="number">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                <label class="col-sm-4">Pommeaux:</label>
                                <div class="col-sm-8">
                                    <input
                                        class="form-control detail @error('editSale.mousseurs') is-invalid @enderror"
                                        wire:model="editSale.mousseurs" type="number">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                <label class="col-sm-4">Mousseurs:</label>
                                <div class="col-sm-8">
                                    <input class="form-control detail @error('editSale.reglette') is-invalid @enderror"
                                        wire:model="editSale.reglette" type="number">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                <label class="col-sm-4">Réglettes:</label>
                                <div class="col-sm-8">
                                    <input
                                        class="form-control detail @error('editSale.pommeaux') is-invalid @enderror"
                                        wire:model="editSale.pommeaux" type="number" {{-- disabled --}}>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                <label class="col-sm-4">Spot picket:</label>
                                <div class="col-sm-8">
                                    <input class="form-control detail @error('editSale.spot') is-invalid @enderror"
                                        wire:model="editSale.spot" type="number" {{-- disabled --}}>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0; display: flex; align-items: center;">
                                <label class="col-sm-4">Tubes:</label>
                                <div class="col-sm-8">
                                    <input class="form-control detail @error('editSale.tube') is-invalid @enderror"
                                        wire:model="editSale.tube" type="number" {{-- disabled --}}>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @cannot('agent')
            <div class="d-flex flex-row-reverse">
                <button type="submit" class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-lg" viewBox="0 0 16 16">
                        <path
                            d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                    </svg>
                    Enregistrer</button>&nbsp;
            </div>
        @endcannot

</div>
</div>
<!-- /.card-body -->
</form>


</div>
