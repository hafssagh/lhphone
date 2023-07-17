<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des ventes</h4><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.debounce.250ms="search"
                                placeholder="Rechercher ...">
                            <span class="input-group-text"><i class="icon-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form wire:submit.prevent="render">
                            <select class="form-select" wire:model="selectedStatus" wire:change="render"
                                id="selectedStatus" style="font-size: 13px">
                                <option value="all">Tous les statut</option>
                                <option value="2">Cmd confirmée</option>
                                <option value="3">Devis envoyé</option>
                                <option value="1">Devis signé</option>
                                <option value="-1">Devis refusé</option>
                                <option value="5">En attente de livraison</option>
                                <option value="6">Livré</option>
                                <option value="7">AH envoyé</option>
                                <option value="8">AH signé</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddSale"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Nouvelle vente</button>
            </div>
        </div><br>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        @cannot('agent')
                            <th><span style=" margin-left:20px">Agent</span></th>
                        @endcannot
                        <th class="text-center">Quantité</th>
                        <th class="text-center">Date de vente</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Date de confirm.</th>
                        <th>Société</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td style="padding: 0.6rem;">
                                <button wire:click="editSale({{ $sale->id }})"
                                    style="border:none; background-color:white">
                                    @if ($sale->state == '2')
                                        <div class="square_table" style="background-color: #c9c6c6;"></div>
                                    @elseif($sale->state == '3')
                                        <div class="square_table" style="background-color: #b09dd4;"></div>
                                    @elseif($sale->state == '1')
                                        <div class="square_table" style="background-color: #b0d4b1;"></div>
                                    @elseif($sale->state == '-1')
                                        <div class="square_table" style="background-color: #f5a7a1;"></div>
                                    @elseif ($sale->state == '5')
                                        <div class="square_table" style="background-color: #7dc098;"></div>
                                    @elseif ($sale->state == '6')
                                        <div class="square_table" style="background-color: #89dbd2;"></div>
                                    @elseif ($sale->state == '7')
                                        <div class="square_table" style="background-color: #9CCDDF;"></div>
                                    @elseif ($sale->state == '8')
                                        <div class="square_table" style="background-color: #8ABCCE;"></div>
                                    @endif
                                </button>
                            </td>
                            @cannot('agent')
                                <td style="padding: 0.3rem;">
                                    <span style=" margin-left:20px">{{ $sale->users->first_name }}</span>
                                </td>
                            @endcannot
                            <td class="text-center" style="padding: 0.3rem;">{{ $sale->quantity }}</td>
                            <td style="padding: 0.3rem;" class="text-center">{{ \Carbon\Carbon::parse($sale->date_sal)->format('d-m-Y') }}</td>
                            <td style="padding: 0.3rem;" class="text-center">
                                @if ($sale->state == '2')
                                    <div class="badge badge-opacity-dark" style="background-color: #cccccc;">En attente
                                        d'envoi</div>
                                @elseif($sale->state == '3')
                                    <div class="badge badge-opacity-dark"
                                        style="background-color: #d9cdf3; color:#75609c">Devis
                                        envoyé</div>
                                @elseif($sale->state == '1')
                                    <div class="badge badge-opacity-success" style="background-color: #d5ebd6;">Devis
                                        signé</div>
                                @elseif($sale->state == '-1')
                                    <div class="badge badge-opacity-danger" style="background-color: #fedfdd;">Devis
                                        refusé</div>
                                @elseif($sale->state == '5')
                                    <div class="badge badge-opacity-success" style="background-color: #b8e6ca;">En
                                        attente
                                        de livraison</div>
                                @elseif($sale->state == '6')
                                    <div class="badge badge-opacity-dark"
                                        style="background-color: #bbece6; color:#3d7c75;">Livré</div>
                                @elseif($sale->state == '7')
                                    <div class="badge badge-opacity-primary"
                                        style="background-color: #9ccddfc0;color: #427c91;">AH envoyé
                                    </div>
                                @elseif($sale->state == '8')
                                    <div class="badge badge-opacity-primary"
                                        style="background-color: #83cbe6;color: #0d455a;">AH signé
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 0.3rem;" class="text-center">
                                @if ($sale->state == '2' || $sale->state == '3')
                                    <div class="spinner-border text-dark" role="status"
                                        style="width:16px ;height:16px">
                                        <span class="sr-only"></span>
                                    </div>
                                @elseif($sale->state == '1' || $sale->state == '-1')
                                    {{ \Carbon\Carbon::parse($sale->date_confirm)->format('d-m-Y') }} 

                                @else
                                    {{ $sale->updated_at->format('Y-m-d') }}
                                @endif
                            </td>
                            <td style="padding: 0.3rem;">
                                <p class="text-dark fw-bold" style="margin-bottom: 0;">{{ $sale->name_client }}</p>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">Email</span>: {{ $sale->mail_client }} &nbsp;
                                    <span class="text-dark">No</span>: {{ $sale->phone_client }}
                                </p>
                            </td>
                            <td><span>
                                    @if ($sale->remark == 'rive')
                                        <span class=" vertical-text2 text-primary"><strong> Eco<br> Rive</strong>
                                        </span>
                                    @elseif ($sale->remark == 's2ee')
                                        <span class=" vertical-text2 text-success"><strong>s2ee</strong>
                                        </span>
                                    @endif
                                </span></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>
<script>
    window.addEventListener('showSuccessMessage', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast: 'success',
            title: event.detail.message || "Opération effectuée avec succès",
            showConfirmButton: false,
            timer: 5000
        })
    });
</script>
