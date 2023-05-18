<div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item d-none d-lg-block">
            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                <span class="input-group-addon input-group-prepend border-right">
                    <span class="icon-calendar input-group-text calendar-icon"></span>
                </span>
                <input type="text" class="form-control" placeholder="<?php $date = date('d/m/Y');
                echo $date; ?>">
            </div>
        </li>
        <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                @if (userPicture() != '')
                    <img class="img-xs rounded-circle" src="{{ asset('storage/' . userPicture()) }}"
                        style="height: 32px; width:32px">
                @else
                    <img class="img-xs rounded-circle" src="/assets/images/user.png" alt="">
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                    @if (userPicture() != '')
                        <img class="img rounded-circle img-thumbnail" src="{{ asset('storage/' . userPicture()) }}"
                            style="height: 75px; width:75px">
                    @else
                        <img class="img rounded-circle img-thumbnail" src="/assets/images/user.png" alt="">
                    @endif
                    <h6 class="mb-1 mt-3">{{ userName() }}</h6>
                        <p class="fw-light text-muted mb-0">{{ getRolesName()}}</p>
                </div>
                <a class="dropdown-item" href="{{ route('user.profile') }}"><i
                        class="dropdown-item-icon mdi mdi-account-outline me-2" style="color:#1F3BB3"></i> Mon Profile
                    </span></a>
                <a class="dropdown-item" href="{{ route('profile.update') }}"><i
                        class="dropdown-item-icon mdi mdi-lock-outline me-2" style="color:#1F3BB3"></i> Sécurité</a>
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
        </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
        data-bs-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
    </button>
</div>
