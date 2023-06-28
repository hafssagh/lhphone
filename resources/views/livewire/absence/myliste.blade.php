<div class="card-body">
    <div class="row">
        <div class="col-6 grid-margin">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="card-title card-title-dash">Mes absences du jour</h4>
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
                                                <small class="text-muted mb-0">{{ $absenceAuth->date }} &nbsp;
                                                    @if ($absenceAuth->justification == null)
                                                        <span style="color:#f73122; font-size: 12px;">
                                                            <strong>Non justifié </strong>
                                                        </span>
                                                    @else
                                                        <span style="color:rgb(66, 182, 174); font-size: 12px;">
                                                            <strong>Justifié</strong>
                                                        </span>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-muted text-small">
                                            @if ($absenceAuth->abs_hours == -1)
                                                <div class="badge" style="background-color: #bbc9fd ; color:black">
                                                    Retard
                                                </div>
                                            @elseif ($absenceAuth->abs_hours >= 1 && $absenceAuth->abs_hours <= 3)
                                                <div class="badge" style="background-color: #b2e7eb ; color:black">
                                                    1h-3h absence
                                                </div>
                                            @elseif ($absenceAuth->abs_hours == 4)
                                                <div class="badge" style="background-color: #fdd991 ; color:black">
                                                    1/2 absence
                                                </div>
                                            @elseif ($absenceAuth->abs_hours > 4)
                                                <div class="badge" style="background-color: #f8f88b ; color:black">
                                                    Absence
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            @if ($suspension->isNotEmpty())
                <div class="col-lg-12 ">
                    @foreach ($suspension as $s)
                        <div class="alert alert-danger" role="alert">
                            Suspendu du &nbsp; <a class="alert-link"> {{ $s->date_debut }} </a> &nbsp; jusqu'au &nbsp; <a class="alert-link">
                                {{ $s->date_fin }} </a>
                        </div>
                    @endforeach
                </div>
            @endif
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
                                    <th style="font-weight: lighter;  padding: 0.5rem; ">
                                        {{ auth()->user()->work_hours }}
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
                                    <h4 class="card-title card-title-dash">Mes absences du mois</h4>
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
                                                <small class="text-muted mb-0">{{ $absence->date }} &nbsp;
                                                    @if ($absence->justification == null)
                                                        <span style="color:#f73122; font-size: 12px;">
                                                            <strong>Non justifié </strong>
                                                        </span>
                                                    @else
                                                        <span style="color:rgb(66, 182, 174); font-size: 12px;">
                                                            <strong>Justifié</strong>
                                                        </span>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-muted text-small">
                                            @if ($absence->abs_hours == -1)
                                                <div class="badge" style="background-color: #bbc9fd ; color:black">
                                                    Retard
                                                </div>
                                            @elseif ($absence->abs_hours >= 1 && $absence->abs_hours <= 3)
                                                <div class="badge" style="background-color: #b2e7eb ; color:black">
                                                    1h-3h absence
                                                </div>
                                            @elseif ($absence->abs_hours == 4)
                                                <div class="badge" style="background-color: #fdd991 ; color:black">
                                                    1/2 absence
                                                </div>
                                            @elseif ($absence->abs_hours > 4)
                                                <div class="badge" style="background-color: #f8f88b ; color:black">
                                                    Absence
                                                </div>
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
