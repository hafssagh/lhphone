<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des ventes</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            @can('manager')
                <div class="border-top border-bottom">
                    <ul class="nav profile-navbar">
                        <li class="nav-item">
                            <button class="btn btn-lg text-black mb-0 me-0" type="button"wire:click="filterState()"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                Tout
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="filterState('1')"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                <i class="mdi mdi-check" style="font-size: 13px;"></i>
                                Accepté
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="filterState('2')"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                <i class="mdi mdi-reload" style="font-size: 13px;"></i>
                                En cours
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-lg text-black mb-0 me-0" type="button"wire:click="filterState('-1')"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                <i class="mdi mdi-window-close" style="font-size: 13px;"></i>
                                Refusé
                            </button>
                        </li>
                    </ul>
                </div>
            @endcan
            @can('agent')
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
            @endcan
        </div><br>
        <div class="table">
            <table class="table">
                <thead>
                    <tr>
                        @can('manager')
                            <th class="text-center">Agent</th>
                        @endcan
                        <th class="text-center">Quantité</th>
                        <th class="text-center">Date de vente</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Date de confirmation</th>
                        <th>Société</th>
                        @can('manager')
                            <th class="text-center">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            @can('manager')
                                <td style="padding: 0.8rem;"> {{ $sale->users->last_name }} {{ $sale->users->first_name }}
                                </td>
                            @endcan
                            <td class="text-center" style="padding: 0.8rem;">{{ $sale->quantity }}</td>
                            <td style="padding: 0.8rem;" class="text-center">{{ $sale->date_sal }}</td>
                            <td style="padding: 0.8rem;" class="text-center">
                                @if ($sale->state == '2')
                                    <div class="spinner-border text-info" role="status"
                                        style="width:16px ;height:16px">
                                        <span class="sr-only"></span>
                                    </div>
                                @elseif ($sale->state == '1')
                                    <div style="color:#198754">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </svg>
                                    </div>
                                @elseif ($sale->state == '-1')
                                    <div style="color:#DC3545">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 0.8rem;" class="text-center">
                                @if ($sale->state == '2')
                                    <p class="blinking-text">En attente</p>
                                @else
                                    {{ $sale->date_confirm }}
                                @endif
                            </td>
                            <td style="padding: 0.8rem;">
                                <p class="text-dark fw-bold" style="margin-bottom: 0;">Emma Smith</p>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">Email</span>: smith@kpmg.com &nbsp;
                                    <span class="text-dark">No</span>: 85886889
                                </p>
                            </td>
                            @can('manager')
                                <td class="text-center" style="padding: 0.8rem;">
                                    @if ($sale->state == '2')
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
                                    @else
                                        {{--    <a href="javascript:;" class="btn btn-sm btn-icon"
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
                                        </a> --}}
                                    @endif
                                </td>
                            @endcan
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{-- {{ $sales->links() }} --}}
            </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>