<div class="card-body">
    <div class="row">
        <div class="col-6 grid-margin">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="card-title card-title-dash">Mes absences du mois</h4>
                                </div>
                            </div>
                            <div class="mt-3">
                                @foreach ($absencesAuth as $absenceAuth)
                                    <div
                                        class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                        <div class="d-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                                                <path
                                                    d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                            </svg>
                                            <div class="wrapper ms-3">
                                                <p class="ms-1 mb-1 fw-bold">Absence journée</p>
                                                <small class="text-muted mb-0">{{ $absenceAuth->date }}</small>
                                            </div>
                                        </div>
                                        <div class="text-muted text-small">
                                            @if ($absenceAuth->justification == null)
                                                <div
                                                    class="badge badge-opacity-danger"style="background-color: #fedfdd;">
                                                    Non justifié</div>
                                            @else
                                                <div class="badge badge-opacity-success">Justifié</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="col-lg-8 ">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="padding: 0.5rem;">Heures d'absence </th>
                                    <th style="font-weight: lighter;  padding: 0.5rem; "> {{ $this->sumAbs() }}</th>
                                </tr>
                                <tr>
                                    <th style="padding: 0.5rem;">Heures de travail </th>
                                    <th style="font-weight: lighter;  padding: 0.5rem; ">{{ $this->workHours() }}
                                        <strong> &nbsp;/ &nbsp; {{ calculerHeuresTravailParMois() }}</strong>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="padding: 0.3rem;"></th>
                                    <th style="padding: 0.3rem;"></th>
                                    <th style="padding: 0.3rem;"></th>
                                </tr>
                                <tr style=" border-top: 0.1em solid rgb(209, 209, 209);">
                                    <th style="padding: 0.5rem;">Salaire</th>
                                    <th style="font-weight: lighter;  padding: 0.5rem;" class="text-danger">
                                        <strong>{{ auth()->user()->salary }} DH</strong>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body" style="max-height: 440px; overflow-y: auto;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="card-title card-title-dash">Historique</h4>
                                </div>
                            </div>
                            <div class="mt-3">
                                @foreach ($absencesAll as $absence)
                                    <div
                                        class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                        <div class="d-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                                                <path
                                                    d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                            </svg>
                                            <div class="wrapper ms-3">
                                                <p class="ms-1 mb-1 fw-bold">Absence journée</p>
                                                <small class="text-muted mb-0">{{ $absence->date }}</small>
                                            </div>
                                        </div>
                                        <div class="text-muted text-small">
                                            @if ($absence->justification == null)
                                                <div
                                                    class="badge badge-opacity-danger"style="background-color: #fedfdd;">
                                                    Non justifié</div>
                                            @else
                                                <div class="badge badge-opacity-success">Justifié</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
