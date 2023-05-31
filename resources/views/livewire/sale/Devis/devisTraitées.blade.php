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
            <div class="border-top border-bottom">
                <ul class="nav profile-navbar">
                    <li class="nav-item">
                        <button class="btn btn-lg text-black mb-0 me-0" type="button"wire:click="filterState('')"
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
                        <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="filterState('-1')"
                            style="font-size: 14px; line-height: 18px; padding: 8px;">
                            <i class="mdi mdi-window-close" style="font-size: 13px;"></i>
                            Refusé
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
                                @if ($sale->state == '1')
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
                            <td style="padding: 0.7rem;" class="text-center">
                                {{ $sale->date_confirm }}
                            </td>
                            <td style="padding: 0.7rem;">
                                <p class="text-dark fw-bold" style="margin-bottom: 0;">{{$sale->name_client}}</p>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">Email</span>: smith@kpmg.com &nbsp;
                                    <span class="text-dark">No</span>: 85886889
                                </p>
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
