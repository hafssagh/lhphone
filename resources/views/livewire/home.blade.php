<div class="navbar-nav">
    <h4 class="welcome-text">Bienvenue, <span class="text-black fw-bold">{{ userName() }}</span></h4>
</div>
<br>
<div class="row">
    <div class="col-md-3 grid-margin">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Calendrier</h4>
                    <div class="d-flex justify-content-between" style="margin-top:-5px">
                        <div class="text-start">
                            <p class="current-date"></p>
                        </div>
                        <div class="icons">
                            <span id="prev" class="material-symbols-rounded" style="display: inline-block;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                </svg>
                            </span>
                            <span id="next" class="material-symbols-rounded" style="display: inline-block;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                    </div><br>
                    <div class="calendar" style="margin-top:-10px">
                        <ul class="weeks">
                            <li class="day">Dim</li>
                            <li class="day">Lun</li>
                            <li class="day">Mar</li>
                            <li class="day">Mer</li>
                            <li class="day">Jeu</li>
                            <li class="day">Ven</li>
                            <li class="day">Sam</li>
                        </ul>
                        <ul class="days" style="margin-top:-10px"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <a href="../assets/Règlement interne.pdf" target="_blank" rel="noopener noreferrer"
                        class="fw-bold text-primary">
                        Réglement interne
                    </a>
                </div>
            </div>
        </div>
    </div>
    @cannot('agent')
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @foreach ($userDirecteur as $userdirecteur)
                            <div class="d-flex justify-content-between ">
                                <div style="display: flex; align-items: center;">
                                    <img class="rounded" src="../assets/images/user2.png"
                                        style="height: 50px; width: 50px;">
                                    <div style="margin-left: 15px;">
                                        <p class="text-danger fw-bold" style="margin-bottom: 0;">Directeur</p>
                                        <p class="text-truncate" style="margin-bottom: 0;">
                                            {{ $userdirecteur->last_name }}
                                            {{ $userdirecteur->first_name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($userManager as $usermanager)
                            <div class="col-md-6" style=" margin-left: -2px; margin-top: 1em;">
                                <div style="display: flex; align-items: center;">
                                    @if ($usermanager->photo != '' || $usermanager->photo != null)
                                        <img class="rounded" src="{{ asset('storage/' . $usermanager->photo) }}"
                                            style="height: 50px; width: 50px;">
                                    @else
                                        <img class="rounded" src="../assets/images/user2.png"
                                            style="height: 50px; width: 50px; ">
                                    @endif
                                    <div style="margin-left: 15px;">
                                        <p class="fw-bold" style="margin-bottom: 0;">Manager</p>
                                        <p class="text-truncate name" tyle="margin-bottom: 0;">
                                            {{ $usermanager->last_name }}
                                            {{ $usermanager->first_name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($userAdmin as $useradmin)
                            <div class="col-md-6" style=" margin-left: -2px; margin-top: 1em;">
                                <div style="display: flex; align-items: center;">
                                    @if ($useradmin->photo != '' || $useradmin->photo != null)
                                        <img class="rounded" src="{{ asset('storage/' . $useradmin->photo) }}"
                                            style="height: 50px; width: 50px;">
                                    @else
                                        <img class="rounded" src="../assets/images/user2.png"
                                            style="height: 50px; width: 50px; ">
                                    @endif
                                    <div style="margin-left: 15px ; margin-bottom: 0;">
                                        <P class="fw-bold" style="margin-bottom: 0;">Responsable informatique</P>
                                        <p class="text-truncate" style="margin-bottom: 0;">{{ $useradmin->last_name }}
                                            {{ $useradmin->first_name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($userAdmin2 as $useradmin2)
                            <div class="col-md-6" style=" margin-left: -2px; margin-top: 1em;">
                                <div style="display: flex; align-items: center;">
                                    @if ($useradmin2->photo != '' || $useradmin2->photo != null)
                                        <img class="rounded" src="{{ asset('storage/' . $useradmin2->photo) }}"
                                            style="height: 50px; width: 50px;">
                                    @else
                                        <img class="rounded" src="../assets/images/user2.png"
                                            style="height: 50px; width: 50px; ">
                                    @endif
                                    <div style="margin-left: 15px ; margin-bottom: 0;">
                                        <P class="fw-bold" style="margin-bottom: 0;">Chargée informatique</P>
                                        <p class="text-truncate" style="margin-bottom: 0;">
                                            {{ $useradmin2->last_name }}
                                            {{ $useradmin2->first_name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @foreach ($userRh as $userRh)
                    <div class="row">
                        <div style=" margin-left: -2px; margin-top: 1em;">
                            <div style="display: flex; align-items: center;">
                                <img class="rounded" src="../assets/images/user2.png"
                                    style="height: 50px; width: 50px; ">
                                <div style="margin-left: 15px ; margin-bottom: 0; width:150px">
                                    <P class="fw-bold" style="margin-bottom: 0;">Chargée ressources humaines</P>
                                    <p class="text-truncate" style="margin-bottom: 0;">
                                        {{ $userRh->last_name }}
                                        {{ $userRh->first_name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Agents</h4>
                    <div class="row">
                        @foreach ($userAgent as $user)
                            <div class="col-md-4" style=" align-items: center;  margin-bottom: 1.5px;">
                                @if ($user->photo != '' || $user->photo != null)
                                    <img class="rounded" src="{{ asset('storage/' . $user->photo) }}"
                                        style="height: 50px; width: 50px;">
                                @else
                                    <img class="rounded" src="../assets/images/user2.png"
                                        style="height: 50px; width: 50px; ">
                                @endif
                                <br>
                                <p class="text-truncate">{{ $user->last_name }} {{ $user->first_name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-lg text-black mb-0 me-0" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" style="font-size: 14px; line-height: 18px; padding: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                            class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z" />
                            <path fill-rule="evenodd"
                                d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                        Voir plus
                    </button>
                </div>
            </div>
        </div>
    @endcannot
    @if (Auth::user()->company == 'lh')
        @can('agent')
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-center" style=" font-weight:bold">Prime</th>
                                    <th class="text-center" style=" font-weight:bold">Challenge</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem;">1 000 P = 1 500 Dh</td>
                                    <td class="text-center" style="padding: 0.4rem;">300 P = 200 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem;">1 400 P = 2 500 Dh</td>
                                    <td class="text-center" style="padding: 0.4rem;">400 P = 300 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem;">1 800 P = 3 500 Dh</td>
                                    <td class="text-center" style="padding: 0.4rem;">500 P = 400 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem;">2 200 P = 4 500 Dh</td>
                                    <td class="text-center" style="padding: 0.4rem;">600 P = 500 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem;">2 600 P = 5 500 Dh</td>
                                    <td class="text-center" style="padding: 0.4rem;">700 P = 600 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem;">3 000 P = 6 500 Dh</td>
                                    <td class="text-center" style="padding: 0.4rem;">800 P = 700 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem;">3 400 P = 7 500 Dh</td>
                                    <td class="text-center" style="padding: 0.4rem;">900 P = 800 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted" style="padding: 1rem;" colspan="2">
                                        NB : Le Challenge est plafonné
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-square-fill blinking-text text-danger" viewBox="0 0 16 16">
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>&nbsp; Rappels d'aujourd'hui
                        </h4>
                        @if ($rappel->isEmpty())
                            <span><i>Aucun rappel n'est prévu pour aujourd'hui.</i> </span>
                        @endif
                        <ul class="bullet-line-list2">
                            @foreach ($rappel as $rappels)
                                <li>
                                    <div class="d-flex justify-content-between">
                                        <div><strong>{{ $rappels->company }}</strong><span>
                                                ({{ $rappels->nameClient }})
                                            </span> </div>
                                        <p>{{ \Carbon\Carbon::parse($rappels->rappel)->format('H:i') }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="list align-items-center pt-3">
                            <div class="wrapper w-100">
                                <p class="mb-0">
                                    <a href="/proposal/all" class="fw-bold text-primary">Voir plus <i
                                            class="mdi mdi-arrow-right ms-2"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    @endif
    @if (Auth::user()->company == 'h2f')
        @can('agent')
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-center" style=" font-weight:bold">Prime</th>
                                    <th class="text-center" style=" font-weight:bold">Challenge</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="padding: 0.5rem;">2 Confirmés = 100 Dh</td>
                                    @if (Auth::user()->base_salary >= 3500 && Auth::user()->base_salary <= 4500)
                                        <td class="text-center" style="padding: 0.5rem;">9 Confirmés = 800 Dh</td>
                                    @elseif (Auth::user()->base_salary == 5000)
                                        <td class="text-center" style="padding: 0.5rem;">12 Confirmés = 800 Dh</td>
                                    @elseif (Auth::user()->base_salary == 5500)
                                        <td class="text-center" style="padding: 0.5rem;">14 Confirmés = 800 Dh</td>
                                    @elseif (Auth::user()->base_salary == 6000)
                                        <td class="text-center" style="padding: 0.5rem;">16 Confirmés = 800 Dh</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.5rem;">3 Confirmés = 200 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.5rem;">4 Confirmés = 300 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 0.5rem;">5 Confirmés = 400 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted" style="padding: 1rem;" colspan="2">
                                        NB : Plus 100 Dh pour chaque rendez-vous de plus
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endcan
    @endif
</div>

@if (Auth::user()->company != 'h2f')
    @canany(['superadmin', 'manager'])
        <div class="row">
            <div class="col-md-3 grid-margin"></div>
            <div class="col-md-9 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-square-fill blinking-text text-danger" viewBox="0 0 16 16">
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>&nbsp; Rappels d'aujourd'hui
                        </h4>
                        @if ($rappelManager->isEmpty())
                            <span><i>Aucun rappel n'est prévu pour aujourd'hui.</i> </span>
                        @endif
                        <div class="list-container2">
                            <ul class="bullet-line-list2">
                                @foreach ($rappelManager as $rappelM)
                                    <li>
                                        <div class="d-flex justify-content-between">
                                            <div><strong>{{ $rappelM->company }}</strong><span>
                                                    ({{ $rappelM->nameClient }})
                                                </span><span class="text-muted">// {{ $rappelM->users->first_name }}
                                                </span>
                                            </div>
                                            <p style="margin-right: 10px">
                                                {{ \Carbon\Carbon::parse($rappelM->rappel)->format('H:i') }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="list align-items-center pt-3">
                            <div class="wrapper w-100">
                                <p class="mb-0">
                                    <a href="/proposal/all" class="fw-bold text-primary">Voir plus <i
                                            class="mdi mdi-arrow-right ms-2"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcanany
@endif
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Agents</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-scrollable-content">
                    <div class="row">
                        @foreach ($userGet as $userAll)
                            <div class="col-md-4" style=" margin-left: -2px; margin-top: 0.8em;">
                                <div style="display: flex; align-items: center;">
                                    @if ($userAll->photo != '' || $userAll->photo != null)
                                        <img class="rounded" src="{{ asset('storage/' . $userAll->photo) }}"
                                            style="height: 50px; width: 50px;"> <br>
                                    @else
                                        <img class="rounded" src="../assets/images/user2.png"
                                            style="height: 50px; width: 50px;">
                                    @endif
                                    <br>
                                    <div style="margin-left: 15px;">
                                        <p class="text-truncate" style="margin-bottom: 0; width:150px">
                                            {{ $userAll->last_name }}
                                            {{ $userAll->first_name }}</p>
                                        <div style="display: inline-block;">
                                            @if ($userAll->company == 'h2f')
                                                <img src="../assets/images/h2f2.png"
                                                    style="height: 20px; width: 35px;display: inline-block;">
                                            @else
                                                <img src="../assets/images/lh2.png"
                                                    style="height: 23px; width: 25px;display: inline-block;">
                                            @endif
                                            @if ($userAll->group == '1')
                                                <p style="font-size: 11px; display: inline-block; color:blue">
                                                    Equipe
                                                    Chris
                                                    Ezzahra</p>
                                            @elseif ($userAll->group == '2')
                                                <p class="text-danger" style="font-size: 11px;display: inline-block;">
                                                    Equipe
                                                    Amine
                                                </p>
                                            @endif
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
</div>
