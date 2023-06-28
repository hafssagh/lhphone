<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des ventes</h4><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.debounce.250ms='search'
                                placeholder="Rechercher ...">
                            <span class="input-group-text"><i class="icon-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form wire:submit.prevent="render">
                            <select class="form-select" wire:model="selectedMonth" id="selectedMonth" style="font-size: 13px">
                                <option value="all">Tous les mois</option>
                                <option value="1">Janvier</option>
                                <option value="2">Février</option>
                                <option value="3">Mars</option>
                                <option value="4">Avril</option>
                                <option value="5">Mai</option>
                                <option value="6">Juin</option>
                                <option value="7">Juillet</option>
                                <option value="8">Août</option>
                                <option value="9">Septembre</option>
                                <option value="10">Octobre</option>
                                <option value="11">Novembre</option>
                                <option value="12">Décembre</option>
                            </select>
                        </form>
                    </div>
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
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th> <span style=" margin-left:20px">Agent</span> </th>
                        <th class="text-center">Quantité</th>
                        <th class="text-center">Date de vente</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Date de confirm.</th>
                        <th>Société</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td style="padding: 0.3rem;" > 
                                <span style=" margin-left:20px">{{ $sale->users->first_name }}</span>
                            </td>
                            <td class="text-center" style="padding: 0.3rem;">{{ $sale->quantity }}</td>
                            <td style="padding: 0.3rem;" class="text-center">{{ $sale->date_sal }}</td>
                            <td style="padding: 0.3rem;" class="text-center">
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
                            <td style="padding: 0.3rem;" class="text-center">
                                {{ $sale->date_confirm }}
                            </td>
                            <td style="padding: 0.3rem;">
                                <p class="text-dark fw-bold" style="margin-bottom: 0;">{{$sale->name_client}}</p>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span class="text-dark">Email</span>: {{ $sale->mail_client }} &nbsp;
                                    <span class="text-dark">No</span>: {{ $sale->phone_client }}
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
