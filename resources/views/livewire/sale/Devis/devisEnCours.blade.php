@if ($currentPage == PAGEEDITFORM)
@include('livewire.sale.edit')
@endif
@if ($currentPage == PAGECREATEFORM)
@include('livewire.sale.create')
@endif
<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des ventes</h4>
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
                </div><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div class="border-top border-bottom">
                <ul class="nav profile-navbar">
                    <li class="nav-item">
                        <button class="btn btn-lg text-black mb-0 me-0" type="button"wire:click="filterState()"
                            style="font-size: 14px; line-height: 18px; padding: 8px;">
                            Tout
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-lg text-black mb-0 me-0" type="button"wire:click="filterState('3')"
                            style="font-size: 14px; line-height: 18px; padding: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                class="bi bi-send" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                            </svg>
                            Envoyé
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="filterState('2')"
                            style="font-size: 14px; line-height: 18px; padding: 8px;">
                            <i class="mdi mdi-reload" style="font-size: 13px;"></i>
                            En attente d'envoi
                        </button>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="table">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Agent</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-center">Date de vente</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Date de confirmation</th>
                        <th>Société</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td style="padding: 0.7rem;"> {{ $sale->users->last_name }} {{ $sale->users->first_name }}
                            </td>
                            <td class="text-center" style="padding: 0.7rem;">{{ $sale->quantity }}</td>
                            <td style="padding: 0.7rem;" class="text-center">{{ $sale->date_sal }}</td>
                            <td style="padding: 0.7rem;" class="text-center">
                                @if ($sale->state == '2')
                                    <p class="blinking-text" style="color: #0dcaf0;">En attente d'envoi</p>
                                @elseif($sale->state == '3')
                                    <p class="blinking-text">Devis envoyé</p>
                                @endif
                            </td>
                            <td style="padding: 0.7rem;" class="text-center">
                                <div class="spinner-border text-info" role="status" style="width:16px ;height:16px">
                                    <span class="sr-only"></span>
                                </div>
                            </td>
                            <td style="padding: 0.7rem;">
                                <p class="text-dark fw-bold" style="margin-bottom: 0;">Emma Smith</p>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">Email</span>: smith@kpmg.com &nbsp;
                                    <span class="text-dark">No</span>: 85886889
                                </p>
                            </td>
                            <td class="text-center" style="padding: 0.7rem;">
                                @if ($sale->state == '3')
                                    <span class="svg-icon svg-icon-md" style="color: #198754"
                                        wire:click='saleValide({{ $sale->id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                        </svg>
                                    </span>&nbsp;
                                    <span class="svg-icon svg-icon-md" style="color :#DC3545"
                                        wire:click='saleRefuse({{ $sale->id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                        </svg>
                                    </span>
                                @endif
                                @if ($sale->state == '2')
                                    <span class="svg-icon svg-icon-md" 
                                        wire:click='saleSend({{ $sale->id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />
                                        </svg>
                                    </span>
                                @endif
                                @if ($sale->state == '2')
                                    <a href="javascript:;" class="btn btn-sm btn-icon"
                                        wire:click="editSale({{ $sale->id }})">
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
                            @endif
                            </td>
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