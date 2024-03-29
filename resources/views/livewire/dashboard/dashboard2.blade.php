<div>
    <br>
    @canany(['manager', 'superadmin'])
        <div class="col-md-12 grid-margin">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" href="/dashboard2" role="tab" aria-controls="overview"
                                aria-selected="true">Général</a>
                        </li>
                        @can('superadmin')
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboardRH" role="tab" aria-selected="false">Ressources
                                    humaines</a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboardH" role="tab" aria-selected="false">Suivi Agent</a>
                        </li>
                    </ul>
                        <div class="btn-wrapper" style="margin-top:5px">
                            @if (Auth::user()->last_name === 'ELMOURABIT' ||
                                    Auth::user()->last_name === 'By' ||
                                    Auth::user()->last_name === 'EL MESSIOUI' || Auth::user()->last_name === 'Essaid')
                                <a href="/dashboard3" class="btn btn-otline-dark me-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        class="bi bi-bar-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
                                    </svg>
                                    RG </a>
                            @endif
                            @if (Auth::user()->last_name === 'EL MESSIOUI' || Auth::user()->last_name === 'Hdimane')
                                <a href="/dashboard2" class="btn btn-primary text-white me-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z" />
                                    </svg>
                                    PPV </a>
                            @endif
                            @if (Auth::user()->last_name === 'ELMOURABIT' ||
                                    Auth::user()->last_name === 'By' ||
                                    Auth::user()->last_name === 'EL MESSIOUI' || Auth::user()->last_name === 'Essaid')
                                <a href="/dashboard" class="btn btn-otline-dark me-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        class="bi bi-bar-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
                                    </svg>
                                    Eclairages </a>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    @endcanany
    <div class="row">
        <div class="col-sm-12 grid-margin">
            <div class="row mb-3">
                <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 style="color:#4650dd; font-size: 1.24rem">{{ $cards[0] }} Rendez-vous</h3>
                                    <p class="text-sm mb-0">Envoyés Aujourd'hui</p>
                                </div>
                                <div class="flex-shrink-0 ms-3 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        fill="currentColor" class="bi bi-calendar2-event" viewBox="0 0 16 16">
                                        <path
                                            d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"
                                            style="color: #4650dd" />
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"
                                            style="color: #4650dd" />
                                        <path
                                            d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"style="color: #4650dd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-3"
                            style="background-color: #dadcf8;border-radius:  0 0 1rem 1rem; border-color: transparent;">
                            <div class="row align-items-center  justify-content-center" style="color:#4650dd ">
                                <div class="col-10">
                                    <p class="mb-0">
                                        <strong>
                                            <a href="/appointments" style="text-decoration: none;color: inherit;">En
                                                savoir
                                                plus</a>
                                        </strong>
                                    </p>
                                </div>
                                <div class="col-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15"
                                        fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 style="color:#66bb6a; font-size: 1.26rem">{{ $cards[1] }} Confirmés</h3>
                                    <p class="text-sm mb-0">Aujourd'hui</p>
                                </div>
                                <div class="flex-shrink-0 ms-3 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        fill="currentColor" class="bi bi-calendar2-check" viewBox="0 0 16 16">
                                        <path style="color:#66bb6a"
                                            d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                        <path style="color:#66bb6a"
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                                        <path style="color:#66bb6a"
                                            d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-3"
                            style="background-color: #c8e6c9; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                            <div class="row align-items-center justify-content-center" style="color:#66bb6a">
                                <div class="col-10">
                                    <p class="mb-0">
                                        <strong>
                                            <a href="/appointments" style="text-decoration: none;color: inherit;">En
                                                savoir
                                                plus</a>
                                        </strong>
                                    </p>
                                </div>
                                <div class="col-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15"
                                        fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="text-danger" style="font-size: 1.26rem">{{ $cards[2] }} Rendez-vous
                                    </h3>
                                    <p class="text-sm mb-0">En attente</p>
                                </div>
                                <div class="flex-shrink-0 ms-3 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                        fill="currentColor" class="bi bi-calendar-x" viewBox="0 0 16 16">
                                        <path style="color:#dc3545"
                                            d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V7zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0V9z" />
                                        <path style="color:#dc3545"
                                            d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                        <path style="color:#dc3545"
                                            d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-3"
                            style="background-color: #ffe2e0; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                            <div class="row align-items-center justify-content-center text-danger">
                                <div class="col-10">
                                    <p class="mb-0">
                                        <strong>
                                            <a href="/appointments" style="text-decoration: none;color: inherit;">En
                                                savoir
                                                plus</a>
                                        </strong>
                                    </p>
                                </div>
                                <div class="col-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15"
                                        fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 style="color:#835db4; font-size: 1.26rem">{{ $cards[3] }} Rappel</h3>
                                    <p class="text-sm mb-0"> (NRP / Injoingnable)</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="30"
                                    fill="currentColor" class="bi bi-clipboard-minus" viewBox="0 0 16 16">
                                    <path style="color:#835db4" fill-rule="evenodd"
                                        d="M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
                                    <path style="color:#835db4"
                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                    <path style="color:#835db4"
                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                </svg>
                            </div>
                        </div>
                        <div class="card-footer py-3"
                            style="background-color: #ddd6e7; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                            <div class="row align-items-center justify-content-center" style="color:#835db4">
                                <div class="col-10">
                                    <p class="mb-0">
                                        <strong><a href="/appointments"
                                                style="text-decoration: none;color: inherit;">En
                                                savoir
                                                plus</a></strong>
                                    </p>
                                </div>
                                <div class="col-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15"
                                        fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('superadmin')
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h3 class="card-title">Rendez-vous d'aujourd'hui</h3>
                        </div><br>
                        <div class="list-container1">
                            @foreach ($users1 as $user)
                                <div class="list-group list-group-flush list-group-timeline">
                                    <div class="list-group-item px-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                @if ($user->appointDayCount != null || $user->appointDayCount != 0)
                                                    <div class="avatar me-2 " style="padding: 0.25rem;">
                                                        <div
                                                            class="bg-green-light position-relative overflow-hidden rounded-circle h-100 d-flex align-items-center justify-content-center">
                                                            <span
                                                                class="avatar-text avatar-primary-light">{{ $user->appointDayCount }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="avatar me-2 " style="padding: 0.25rem;">
                                                        <div style="background-color:#ffe2e0"
                                                            class=" position-relative overflow-hidden rounded-circle h-100 d-flex align-items-center justify-content-center">
                                                            <span
                                                                class="avatar-text text-danger">{{ $user->appointDayCount }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <span style="font-size:0.9rem;">
                                                    <strong>{{ $user->last_name }} {{ $user->first_name }}</strong>
                                                </span>
                                                <div class="small text-muted">
                                                    Groupe {{ $user->group }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h3 class="card-title"
                                style=" color: #010101; margin-bottom: 1.2rem; text-transform: capitalize; font-size: 1.126rem; font-weight: 600;">
                                Classement Agent (<span id="mois"></span>)
                        </div>
                        <canvas id="my_chart" style="height: 80%; width:50%"></canvas>
                    </div>
                </div><br><br><br>
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h3 class="card-title"
                        style="color: #010101; margin-bottom: 1.2rem; text-transform: capitalize; font-size: 1.126rem; font-weight: 600;">
                        <svg style="color:#DC3545;" xmlns="http://www.w3.org/2000/svg" width="17" height="22"
                            fill="none" class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                            <path fill="currentColor" stroke="#DC3545" stroke-width="1"
                                d="M0 0h1v15h15v1H0V0Zm10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5Z" />
                        </svg>
                        &nbsp;
                        Agents à 0 ({{ $usersWithoutAppointCount }})
                    </h3>
                </div><br>
                <div id="usersContainer" class="d-sm-flex justify-content-between align-items-start">
                    <a href="{{ $usersWithoutAppoints->previousPageUrl() }}" class="btn btn-dark btn-sm"
                        style="width: 25px; height: 27px; background-color: #0d6efd; border-color: #0d6efd">
                        <svg style="margin-left:-7px; margin-top:-5px" xmlns="http://www.w3.org/2000/svg" width="14"
                            height="14" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                            <path
                                d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                        </svg>
                    </a>
                    @foreach ($usersWithoutAppoints as $usersWithoutAppoint)
                        <div class="col-lg-3 d-flex flex-column" style="margin-top: -20px">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <span class="small text-truncate"
                                        style="display: inline-block; max-width: 130px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                        <strong>{{ $usersWithoutAppoint->first_name }}
                                            {{ $usersWithoutAppoint->last_name }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <a href="{{ $usersWithoutAppoints->nextPageUrl() }}" class="btn btn-dark btn-sm"
                        style="width: 25px; height: 27px; background-color: #0d6efd; border-color: #0d6efd">
                        <svg style="margin-left:-7px; margin-top:-5px" xmlns="http://www.w3.org/2000/svg" width="14"
                            height="14" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                            <path
                                d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="margin-top:30px">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <h3 class="card-title">Les rendez-vous de l'année</h3>
                                </div>
                                <canvas id="appointmentChart" style="height: 70%; width:80%"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <h3 class="card-title">Production</h3>
                                </div>
                                <div class="table table-container">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="padding: 1rem;" class="text-muted">Agent </th>
                                                <th style="padding: 1rem;" class="text-center text-muted">RDV(Jour)</th>
                                                <th style="padding: 1rem;" class="text-center text-muted">RDV(Mois)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td style="padding: 0.6rem; margin-left:-5px">{{ $user->first_name }}
                                                    </td>
                                                    <td class="text-center" style="padding: 0.6rem;">
                                                        @if ($user->sumRDV != 0)
                                                            <strong>{{ $user->sumRDV }} RDV</strong>
                                                        @else
                                                            {{ $user->sumRDV }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center" style="padding: 0.6rem;">
                                                        @if ($user->sumRDV2 != 0)
                                                            <strong>{{ $user->sumRDV2 }} RDV</strong>
                                                        @else
                                                            {{ $user->sumRDV2 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="padding: 0.6rem;"><strong>Total</strong></td>
                                                <td style="padding: 0.6rem;" class="text-center">
                                                    <strong>{{ $sumValues[4] }}
                                                        RDV</strong>
                                                </td>
                                                <td style="padding: 0.6rem;" class="text-center">
                                                    <strong>{{ $sumValues[5] }}
                                                        RDV</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('manager')
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="table table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="padding: 0.6rem;" class="text-muted">Agent</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">Absence</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">Heures travail</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">Salaire fixe</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">Salaire</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">RDV(Jour)</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">Challenge</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">RDV(Mois)</th>
                                        <th style="padding: 0.6rem;" class="text-center text-muted">Prime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td style="padding: 0.6rem;">
                                                <strong>{{ $user->last_name }} {{ $user->first_name }}</strong>
                                            </td>
                                            <td class="text-center" style="padding: 0.6rem;">
                                                @if ($user->absenceHours != 0)
                                                    <strong class="text-danger">{{ $user->absenceHours }} h</strong>
                                                @else
                                                    {{ $user->absenceHours }} h
                                                @endif
                                            </td>
                                            <td class="text-center" style="padding: 0.6rem;">{{ $user->work_hours }} h
                                            </td>
                                            <td class="text-center" style="padding: 0.6rem;">{{ $user->base_salary }}
                                            </td>
                                            <td class="text-center" style="padding: 0.6rem;">{{ $user->salary }}</td>
                                            <td class="text-center" style="padding: 0.6rem;">
                                                @if ($user->sumRDV != 0)
                                                    <strong>{{ $user->sumRDV }} RDV</strong>
                                                @else
                                                    {{ $user->sumRDV }}
                                                @endif
                                            </td>
                                            <td class="text-center" style="padding: 0.6rem;">
                                                @if ($user->challenge != 0)
                                                    <strong style="color: #5E50F9">{{ $user->challenge }} DH</strong>
                                                @else
                                                    {{ $user->challenge }}
                                                @endif
                                            </td>
                                            <td class="text-center" style="padding: 0.6rem;">
                                                @if ($user->sumRDV2 != 0)
                                                    <strong>{{ $user->sumRDV2 }} RDV</strong>
                                                @else
                                                    {{ $user->sumRDV2 }}
                                                @endif
                                            </td>
                                            <td class="text-center" style="padding: 0.6rem;">
                                                @if ($user->prime != 0)
                                                    <strong style="color: #5E50F9">{{ $user->prime }} DH</strong>
                                                @else
                                                    {{ $user->prime }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="padding: 0.6rem;"><strong>Total</strong></td>
                                        <td style="padding: 0.6rem;"></td>
                                        <td style="padding: 0.6rem;"></td>
                                        <td style="padding: 0.6rem;" class="text-center"><strong>{{ $sumValues[1] }}
                                                DH</strong>
                                        </td>
                                        <td style="padding: 0.6rem;" class="text-center"><strong>{{ $sumValues[0] }}
                                                DH</strong>
                                        </td>
                                        <td style="padding: 0.6rem;" class="text-center"><strong>{{ $sumValues[4] }}
                                                RDV</strong>
                                        </td>
                                        <td style="padding: 0.6rem;" class="text-center"><strong>{{ $sumValues[2] }}
                                                DH</strong>
                                        </td>
                                        <td style="padding: 0.6rem;" class="text-center"><strong> {{ $sumValues[5] }}
                                                RDV</strong>
                                        </td>
                                        <td style="padding: 0.6rem;" class="text-center"><strong>{{ $sumValues[3] }}
                                                DH</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            var ctx = document.getElementById('my_chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($users3->pluck('first_name')) !!},
                    datasets: [{
                        label: 'Rdv Confirmés',
                        data: {!! json_encode($users3->pluck('confirme')) !!},
                        backgroundColor: '#e0e0e0',
                        borderColor: '#c2c0c0',
                        barThickness: 30,
                        borderWidth: 2,
                        borderRadius: 20,
                        borderSkipped: false,
                    }]
                },
                options: {
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var date = new Date();
            var mois = date.toLocaleString("default", {
                month: "long"
            });
            var annee = date.getFullYear();
            var mois = mois;

            document.getElementById("mois").textContent = mois;
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initial page load
            loadPageContent("{{ $usersWithoutAppoints->url(1) }}");

            // Event handler for previous page icon click
            $(document).on('click', '#previousPage', function(e) {
                e.preventDefault();
                var prevUrl = $(this).attr('href');
                loadPageContent(prevUrl);
            });

            // Event handler for next page icon click
            $(document).on('click', '#nextPage', function(e) {
                e.preventDefault();
                var nextUrl = $(this).attr('href');
                loadPageContent(nextUrl);
            });

            function loadPageContent(url) {
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        $('#usersContainer').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>


    <script>
        document.addEventListener('livewire:load', function() {
            var months = @json($months);
            var refusedRDV = @json($refusedRDV);
            var acceptedRDV = @json($acceptedRDV);

            var ctx = document.getElementById('appointmentChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                            label: 'Acceptées',
                            data: acceptedRDV,
                            type: 'line',
                            borderColor: '#c2c0c0 ',
                            backgroundColor: '#c2c0c0 ',
                        },
                        {
                            label: 'Annulées',
                            data: refusedRDV,
                            type: 'bar',
                            borderColor: '#e0e0e0',
                            backgroundColor: '#e0e0e0',
                        }
                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    weight: 'bold'
                                },
                            },
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                            },
                        }
                    }
                },
            });
        });
    </script>
