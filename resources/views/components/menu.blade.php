<ul class="nav">
    @can("admin")
    <li class="nav-item {{setMenuActive('home')}}">
        <a class="nav-link" href="{{route('home')}}">
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
    <li class="nav-item nav-category">UI Elements</li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
            aria-controls="ui-basic">
            <i class="menu-icon mdi mdi-account-key"></i>
            <span class="menu-title">Habilitations</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link"
                        href="{{route('admin.habilitations.users.index')}}"></i>Utilisateurs</a></li>
                <li class="nav-item"> <a class="nav-link"
                        href="">Rôles et Permissions</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="mdi mdi-calendar menu-icon"></i>
            <span class="menu-title">Gestion Absence</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="mdi mdi-credit-card-multiple menu-icon"></i>
            <span class="menu-title">Gestion Salaire</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="mdi mdi-logout-variant menu-icon"></i>
            <span class="menu-title">Gestion Départ</span>
        </a>
    </li>
    @endcan
    @can("manager")
    <li class="nav-item">
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
    </li>
    @endcan
    @can("agent")
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="mdi mdi-chart-line menu-icon"></i>
            <span class="menu-title">Gestion Ventes</span>
        </a>
    </li>
    @endcan

</ul>