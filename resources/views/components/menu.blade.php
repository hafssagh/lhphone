<br>
<ul class="nav">
    <li class="nav-item {{ setMenuActive('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Acceuil</span>
        </a>
    </li>
    @canAny(['admin', 'superadmin', 'manager'])
        @can('admin')
            <li class="nav-item {{ setMenuActive('dashboard') }}">
                <a class="nav-link collapsed" href="{{ route('dashRH') }}">
                    <i class="mdi mdi-grid-large menu-icon"></i>
                    <span class="menu-title">Tableau de bord</span>
                </a>
            </li>
        @endcan
        @cannot('admin')
            <li class="nav-item {{ setMenuActive('dashboard') }}">
                <a class="nav-link collapsed" href="{{ route('dashboard') }}">
                    <i class="mdi mdi-grid-large menu-icon"></i>
                    <span class="menu-title">Tableau de bord</span>
                </a>
            </li>
        @endcannot
        <li class="nav-item {{ setMenuActive('users.index') }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="menu-icon mdi mdi-account-key"></i>
                <span class="menu-title">Gestion utilisateur</span>
            </a>
        </li>
        @canAny(['admin', 'superadmin'])
            <li class="nav-item {{ setMenuActive('resignation.index') }}">
                <a class="nav-link" href="{{ route('resignation.index') }}">
                    <i class="mdi mdi-logout-variant menu-icon"></i>
                    <span class="menu-title">Gestion Départ</span>
                </a>
            </li>
        @endcanAny
        <li class="nav-item">
            <a class="nav-link collapse" data-bs-toggle="collapse" href="#tables" aria-expanded="false"
                aria-controls="tables">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Gestion Absence &nbsp;&nbsp;</span>
                <i class="menu-arrow" style="color: grey"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('absence.index') }}">Absences du mois</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('absence.historique') }}">Historique</a>
                    </li>
                </ul>
            </div>
        </li>
        @canAny(['admin', 'superadmin'])
            <li class="nav-item">
                <a class="nav-link collapse" data-bs-toggle="collapse" href="#paie" aria-expanded="false"
                    aria-controls="paie">
                    <i class="mdi mdi-credit-card-multiple menu-icon"></i>
                    <span class="menu-title">Gestion Paie</span>
                    <i class="menu-arrow" style="color: grey"></i>
                </a>
                <div class="collapse" id="paie">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.salary') }}">Salaire</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.challenge_prime') }}">
                                Challenge et Prime</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endcanAny
        @canAny(['manager', 'superadmin'])
            <li class="nav-item ">
                <a class="nav-link collapse" data-bs-toggle="collapse" href="#devis" aria-expanded="false"
                    aria-controls="devis">
                    <i class="mdi mdi-chart-line menu-icon"></i>
                    <span class="menu-title">Gestion Devis</span>
                    <i class="menu-arrow" style="color: grey"></i>
                </a>
                <div class="collapse" id="devis">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('devisOnProcess') }}">
                                En cours de traitement</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('devisEndProcess') }}">
                                Traitement achevé</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('production2') }}">
                                Production</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endcanAny
    @endcanAny


    @can('agent')
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
