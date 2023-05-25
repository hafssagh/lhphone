<ul class="nav">
    @can('admin')
        <li class="nav-item {{ setMenuActive('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Acceuil</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Tableau de bord</span>
            </a>
        </li>
        <li class="nav-item {{ setMenuActive('users.index') }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="menu-icon mdi mdi-account-key"></i>
                <span class="menu-title">Gestion utilisateur</span>
            </a>
        </li>
        <li class="nav-item {{ setMenuActive('resignation.index') }}">
            <a class="nav-link" href="{{ route('admin.resignation.index') }}">
                <i class="mdi mdi-logout-variant menu-icon"></i>
                <span class="menu-title">Gestion Départ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapse" data-bs-toggle="collapse" href="#tables" aria-expanded="false"
                aria-controls="tables">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Gestion Absence &nbsp;&nbsp;</span>
                {{--  <i class="menu-arrow"></i> --}}
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.absence.index') }}">Absences du mois</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.absence.historique') }}">Historique</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('absence.myliste') }}">Mes absences</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.salary') }}" wire:click='calculSalaryWorkH'>
                <i class="mdi mdi-credit-card-multiple menu-icon"></i>
                <span class="menu-title">Gestion Salaire</span>
            </a>
        </li>
    @endcan
    @can('manager')
        <li class="nav-item {{ setMenuActive('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Acceuil</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Tableau de bord</span>
            </a>
        </li>
       {{--  <li class="nav-item">
            <a class="nav-link" href="">
                <i class="mdi mdi-checkbox-multiple-marked-outline menu-icon"></i>
                <span class="menu-title">Gestion Objectif</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="mdi mdi-database menu-icon"></i>
                <span class="menu-title">Gestion Clientèle</span>
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('absence.myliste') }}">
                <i class="mdi mdi-calendar menu-icon"></i>
                <span class="menu-title">Mes Absences</span>
            </a>
        </li>
        <li class="nav-item  {{ setMenuActive('sales.index') }}">
            <a class="nav-link" href="{{ route('sales.index') }}">
                <i class="mdi mdi-chart-line menu-icon"></i>
                <span class="menu-title">Gestion Vente</span>
            </a>
        </li>
    @endcan
    @can('agent')
        <li class="nav-item {{ setMenuActive('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Acceuil</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Tableau de bord</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('absence.myliste') }}">
                <i class="mdi mdi-calendar menu-icon"></i>
                <span class="menu-title">Mes Absences</span>
            </a>
        </li>
        <li class="nav-item  {{ setMenuActive('sales.index') }}">
            <a class="nav-link" href="{{ route('sales.index') }}">
                <i class="mdi mdi-chart-line menu-icon"></i>
                <span class="menu-title">Gestion Vente</span>
            </a>
        </li>
    @endcan
</ul>
