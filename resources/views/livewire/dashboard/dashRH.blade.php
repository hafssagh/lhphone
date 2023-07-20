<div>
    @can('superadmin')
    <br>
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link ps-0" href="/dashboard" role="tab">Général</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/dashboardRH" role="tab" aria-controls="overview"
                                aria-selected="true">Ressources humaines</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboardF" role="tab">Suivi Agent</a>
                        </li>
                    </ul>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endcan
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="row mb-3">
                    <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 style="color:#4650dd; font-size: 1.25rem">{{ $cards[0] }} Utilisateurs
                                        </h3>
                                        <p class="text-sm mb-0">ACTIVE</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                            <path style="color: #4650dd"
                                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                        </svg>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #dadcf8;border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center  justify-content-center" style="color:#4650dd ">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="/users" style="text-decoration: none;color: inherit;">En
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
                    <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="text-danger" style="font-size: 1.25rem">{{ $cards[5] }} Départs
                                        </h3>
                                        <p class="text-sm mb-0">IN-ACTIVE</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="currentColor" class="bi bi-person-fill-dash" viewBox="0 0 16 16">
                                            <path style="color:#dc3545"
                                                d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1Zm0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path style="color:#dc3545"
                                                d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #ffe2e0; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center justify-content-center text-danger">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="/resignation"
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
                    <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 style="color:#66bb6a; font-size: 1.25rem">{{ $cards[4] }} Nouveaux</h3>
                                        <p class="text-sm mb-0">Cette semaine</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                                            <path style="color:#66bb6a"
                                                d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path style="color:#66bb6a"
                                                d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #c8e6c9; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center justify-content-center" style="color:#66bb6a">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="/users" style="text-decoration: none;color: inherit;">En
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
                    <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 style="color:#835db4; font-size: 1.25rem">{{ $cards[6] }} Absence</h3>
                                        <p class="text-sm mb-0">Aujourd'hui</p>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                        fill="currentColor" class="bi bi-person-fill-down" viewBox="0 0 16 16">
                                        <path style="color:#835db4"
                                            d="M12.5 9a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7Zm.354 5.854 1.5-1.5a.5.5 0 0 0-.708-.708l-.646.647V10.5a.5.5 0 0 0-1 0v2.793l-.646-.647a.5.5 0 0 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path style="color:#835db4"
                                            d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #ddd6e7; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center justify-content-center" style="color:#835db4">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="/admin/list"
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
        <div class="row">
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="card-title card-title-dash">Agents (sans contrat)</h3>
                        </div>
                        <div class="list-group list-group-flush list-group-timeline">
                            <div class="list-container">
                                @foreach ($stagiaire as $stage)
                                    <div class="list-group-item px-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar me-2">
                                                    <div
                                                        class="position-relative overflow-hidden rounded-circle h-100 d-flex align-items-center justify-content-center">
                                                        <span
                                                            style="box-sizing:border-box;display:inline-block;overflow:hidden;width:40px;height:40px;background:none;opacity:1;border:0;margin:0;padding:0;position:relative">
                                                            <img src="../assets/images/user2.png"
                                                                class="rounded-circle "
                                                                style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                                                                <noscript><img
                                                                    src="../assets/images/user2.png" decoding="async"
                                                                    data-nimg="fixed"
                                                                    style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%"
                                                                    class="rounded-circle "
                                                                    loading="lazy" /></noscript></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <span style="font-size:0.9rem;">
                                                    <strong>{{ $stage->last_name }} {{ $stage->first_name }}</strong>
                                                </span>
                                                <span style="font-size: 0.812rem;"
                                                    class="text-muted">({{ $stage->company }})</span>
                                                <div class="text-gray-500 small">
                                                    {{ \Carbon\Carbon::parse($stage->created_at)->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="card-title card-title-dash">Resumé des absences</h3>
                        </div>
                        <div>
                            <canvas id="chart" style="height: 500px; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h3 class="card-title card-title-dash">Anniversaire d'aujourd'hui
                                        ({{ $cards[7] }})
                                        <img src="../assets/images/cake.png">
                                    </h3>
                                </div>
                            </div>
                            <div class="mt-3">
                                @foreach ($userGet as $user)
                                    <div
                                        class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                        <div class="d-flex">
                                            @if ($user->photo != '' || $user->photo != null)
                                                <img class="img-xs rounded-circle"
                                                    src="{{ asset('storage/' . $user->photo) }}"
                                                    style="height: 43px; width: 43px;"> <br>
                                            @else
                                                <img class="img-xs rounded-circle" src="../assets/images/user2.png"
                                                    style="height: 43px; width: 43px;">
                                            @endif
                                            <div class="wrapper ms-3">
                                                <p class="ms-1 mb-1 fw-bold">{{ $user->last_name }}
                                                    {{ $user->first_name }}
                                                </p>
                                                <small class="text-muted mb-0">{{ $user->birthday }}</small>
                                            </div>
                                        </div>
                                        <div
                                            style="display: flex; width: 2.2rem; height: 2.2rem; flex-shrink: 0; border-radius: 50%; align-items: center;
                                    justify-content: center; background-color:#fec1bb">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-stars" viewBox="0 0 16 16">
                                                <path style="color:white"
                                                    d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="table table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="padding: 0.8rem;" class="text-muted">Agent</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Absence</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Heures travail</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Salaire fixe</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Salaire/j</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Challenge</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Prime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td style="padding: 0.8rem;">
                                                <strong>{{ $user->last_name }}
                                                {{ $user->first_name }}</strong>
                                            </td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                @if ($user->absenceHours != 0)
                                                <strong class="text-danger">{{ $user->absenceHours }} h</strong> 
                                                @else
                                                 {{ $user->absenceHours }} h 
                                                @endif
                                            </td>
                                            <td class="text-center" style="padding: 0.8rem;">{{ $user->work_hours }} h
                                            </td>
                                            <td class="text-center" style="padding: 0.8rem;">{{ $user->base_salary }} DH
                                            </td>
                                            <td class="text-center" style="padding: 0.8rem;">{{ $user->salary }} DH</td> 
                                            <td class="text-center" style="padding: 0.8rem;">{{ $user->challenge }}
                                            </td>
                                            <td class="text-center" style="padding: 0.8rem;">{{ $user->prime }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-end">
                                <br>
                                <div class="btn-group">
                                    <button wire:click="$set('group', 1)" type="button" class="btn"
                                        style="background-color: #0d6efd; color:white">Groupe 1</button>
                                    <button wire:click="$set('group', 2)" type="button" class="btn"
                                        style="background-color: #0d6efd; color:white">Groupe 2</button>
                                    <button wire:click="$set('group', '3')" type="button" class="btn"
                                        style="background-color: #0d6efd; color:white">H2F</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="padding: 0.8rem;" class="text-muted">Manager</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Absence</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Heures travail</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Salaire fixe</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Salaire/j</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userCardre as $userCardre)
                                        <tr>
                                            <td style="padding: 0.8rem;"> 
                                                <strong>{{ $userCardre->last_name }}
                                                    {{ $userCardre->first_name }}</strong>
                                            </td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                {{ $userCardre->absenceHours }} h</td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                {{ $userCardre->work_hours }} h</td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                {{ $userCardre->base_salary }} DH</td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                {{ $userCardre->salary }} DH
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <thead>
                                    <tr>
                                        <th style="padding: 0.8rem;" class="text-muted">Informaticien</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Absence</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Heures travail</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Salaire fixe</th>
                                        <th style="padding: 0.8rem;" class="text-center text-muted">Salaire/j</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userInfo as $userInfo)
                                        <tr>
                                            <td style="padding: 0.8rem;">
                                                <strong>{{ $userInfo->last_name }}
                                                    {{ $userInfo->first_name }}</strong>
                                            </td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                {{ $userInfo->absenceHours }} h</td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                {{ $userInfo->work_hours }} h</td>
                                            <td class="text-center" style="padding: 0.8rem;">
                                                {{ $userInfo->base_salary }} DH</td>
                                            <td class="text-center" style="padding: 0.8rem;">{{ $userInfo->salary }} DH
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-end">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>

<script>
    const ctx = document.getElementById('chart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: ['Jan', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                data: [{{ $absence[0] }}, {{ $absence[1] }}, {{ $absence[2] }},
                    {{ $absence[3] }}, {{ $absence[4] }}, {{ $absence[5] }},
                    {{ $absence[6] }}, {{ $absence[7] }}, {{ $absence[8] }},
                    {{ $absence[9] }}, {{ $absence[10] }}, {{ $absence[11] }}
                ],
                backgroundColor: 'rgb(192,192,192)',
            }],
        },
        options: {
            responsive: true,
            legend: {
                display: false
            }
        }
    });
</script>
