<div class="navbar-nav">
    <h4 class="welcome-text">Bienvenue, <span class="text-black fw-bold">{{ userName() }}</span></h4>
</div>
<br>
<div class="row">
    <div class="col-md-3 grid-margin ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Calendrier</h4>
                <div class="d-flex justify-content-between" style="margin-top:-5px">
                    <div class="text-start">
                        <p class="current-date"></p>
                    </div>
                    <div class="icons text-end">
                        <span id="prev" class="material-symbols-rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chevron-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                            </svg>
                        </span>
                        <span id="next" class="material-symbols-rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </span>
                    </div>
                </div><br>
                <div class="calendar" style="margin-top:-10px">
                    <ul class="weeks">
                        <li>Dim</li>
                        <li>Lun</li>
                        <li>Mar</li>
                        <li>Mer</li>
                        <li>Jeu</li>
                        <li>Ven</li>
                        <li>Sam</li>
                    </ul>
                    <ul class="days" style="margin-top:-10px"></ul>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Cadres</h4>

                <div class="row">
                    @foreach ($userDirecteur as $userdirecteur)
                        <div class="d-flex justify-content-between ">
                            <div style="display: flex; align-items: center;">
                                <img class="rounded" src="../assets/images/user2.png"
                                    style="height: 50px; width: 50px;">
                                <div style="margin-left: 15px;">
                                    <p class="text-danger fw-bold" style="margin-bottom: 0;">Directeur</p>
                                    <p class="text-truncate" style="margin-bottom: 0;">{{ $userdirecteur->last_name }}
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
                                    <p class="text-truncate" tyle="margin-bottom: 0;">{{ $usermanager->last_name }}
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
                                <div style="margin-left: 15px ; margin-bottom: 0;" >
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
                                <div style="margin-left: 15px ; margin-bottom: 0;" >
                                    <P class="fw-bold" style="margin-bottom: 0;">Chargée informatique</P>
                                    <p class="text-truncate" style="margin-bottom: 0;">{{ $useradmin2->last_name }}
                                        {{ $useradmin2->first_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin ">
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
                            <p class="text-truncate">{{ $user->group }}</p>
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
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin-top:-20px">
                <div class="row">
                    @foreach ($userGet as $userAll)
                        <div class="col-md-6" style=" margin-left: -2px; margin-top: 0.8em;">
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
                                    <p class="text-truncate" style="margin-bottom: 0;">{{ $userAll->last_name }}
                                        {{ $userAll->first_name }}</p>
                                    @if ($userAll->company == 'h2f')
                                        <img src="../assets/images/h2f.png"
                                            style="height: 20px; width: 35px;">
                                    @else
                                        <img src="../assets/images/lh.png"
                                            style="height: 23px; width: 25px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
