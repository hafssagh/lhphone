<div>
    <div class="row grid-margin">
        <div class="col-md-6 grid-margin">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Charges LH Phone</h4>
                        </div>
                        <div>
                            <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddCharge"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                                &nbsp;Ajouter</button>
                        </div>
                    </div><br>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Charge</th>
                                    <th class="text-center">Prix</th>
                                    <th>Fichier</th>
                                    <th class="text-center">Ajouté</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chargesLH as $charge)
                                    <tr>
                                        <td style="padding: 0.6rem;"><strong
                                                style="color: rgb(65, 118, 170); margin-left:20px">{{ $charge->object }}</strong>
                                        </td>
                                        <td style="padding: 0.6rem;" class="text-center">
                                            <strong>{{ $charge->price }}</strong>
                                        </td>
                                        <td style="padding: 0.6rem;">
                                            @if ($charge->file)
                                                <a href="{{ Storage::url($charge->file) }}"
                                                    target="_blank"> Ouvrir</a>
                                            @else
                                                Aucun fichier
                                            @endif
                                        </td>
                                        <td style="padding: 0.6rem;">
                                            <p class="text-dark fw-bold text-center" style="margin-bottom: 0;">
                                                {{ \Carbon\Carbon::parse($charge->created_at)->format('d-m-Y') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Charges H2F Premium</h4>
                        </div>
                        <div>
                            <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddCharge2"
                                style="font-size: 14px; line-height: 18px; padding: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                                &nbsp;Ajouter</button>
                        </div>
                    </div><br>

                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Charge</th>
                                    <th class="text-center">Prix</th>
                                    <th>Fichier</th>
                                    <th class="text-center">Ajouté</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chargesH2F as $chargeh2f)
                                    <tr>
                                        <td style="padding: 0.6rem;"><strong
                                                style="color: rgb(65, 118, 170); margin-left:20px">{{ $chargeh2f->object }}</strong>
                                        </td>
                                        <td style="padding: 0.6rem;" class="text-center">
                                            <strong>{{ $chargeh2f->price }}</strong>
                                        </td>
                                        <td style="padding: 0.6rem;">
                                            @if ($chargeh2f->file)
                                                <a href="{{ Storage::url($chargeh2f->file) }}"
                                                    target="_blank"> Ouvrir</a>
                                            @else
                                                Aucun fichier
                                            @endif
                                        </td>
                                        <td style="padding: 0.6rem;">
                                            <p class="text-dark fw-bold text-center" style="margin-bottom: 0;">
                                                {{ \Carbon\Carbon::parse($charge->created_at)->format('d-m-Y') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
