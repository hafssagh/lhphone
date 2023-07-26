<div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <div class="row">
                <div class="col-auto">
                    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (userPicture() != '')
                            <img class="img-xs rounded-circle" src="{{ asset('storage/' . userPicture()) }}"
                                style="height: 40px; width:40px">
                        @else
                            <img class="img-xs rounded-circle" src="/assets/images/user.png" alt=""
                                style="height: 40px; width:40px">
                        @endif
                    </a>
                </div>
                <div class="col-auto" style="margin-left: -15px">
                    <h6 class="mb-1 mt-3">{{ userName() }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            data-bs-toggle="dropdown" aria-expanded="false" class="bi bi-caret-down "
                            viewBox="0 0 16 16">
                            <path
                                d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z" />
                        </svg>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                @if (userPicture() != '')
                                    <img class="img rounded-circle img-thumbnail"
                                        src="{{ asset('storage/' . userPicture()) }}" style="height: 75px; width:75px">
                                @else
                                    <img class="img rounded-circle img-thumbnail" src="/assets/images/user.png"
                                        alt="">
                                @endif
                                <br><br>
                                <p class="fw-light text-muted mb-0">{{ getRolesName() }}</p>
                            </div>
                            @cannot('superadmin')
                                <a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                        class="dropdown-item-icon mdi mdi-account-outline me-2" style="color:#1F3BB3"></i>
                                    Mon Profile
                                    </span></a>
                                @canAny(['admin', 'manager'])
                                    <a class="dropdown-item" href="{{ route('absence.myliste') }}"><i
                                            class="dropdown-item-icon mdi mdi-calendar me-2" style="color:#1F3BB3"></i>
                                        Mes absences
                                        </span>
                                    </a>
                                @endcannot
                            @endcannot
                            <a class="dropdown-item" href="{{ route('profile.update') }}"><i
                                    class="dropdown-item-icon mdi mdi-lock-outline me-2" style="color:#1F3BB3"></i>
                                Sécurité</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="dropdown-item-icon mdi mdi-power me-2" style="color:#1F3BB3"></i>
                                Se déconnecter
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>

                    </h6>
                </div>
            </div>
        </li>

    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
        data-bs-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
    </button>
</div>
