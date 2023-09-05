<div>
    <br>
    @canany(['manager', 'superadmin'])
        <div class="col-md-12 grid-margin">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" href="/dashboard" role="tab" aria-controls="overview"
                                aria-selected="true">Général</a>
                        </li>
                        @can('superadmin')
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboardRH" role="tab" aria-selected="false">Ressources
                                    humaines</a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboardF" role="tab" aria-selected="false">Suivi Agent</a>
                        </li>
                    </ul>
                    @cannot('manager')
                        <div class="btn-wrapper" style="margin-top:5px">
                            <a href="/dashboard3" class="btn btn-primary text-white  me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z" />
                                    </svg>
                                RG </a>
                            <a href="/dashboard2" class="btn btn-otline-dark me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    class="bi bi-bar-chart" viewBox="0 0 16 16">
                                    <path
                                        d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
                                </svg>
                                PPV </a>
                                <a href="/dashboard" class="btn btn-otline-dark me-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    class="bi bi-bar-chart" viewBox="0 0 16 16">
                                    <path
                                        d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
                                </svg>
                                    Eclairages </a>
                        </div>
                    @endcannot
                </div>
            </div>
        </div>
    @endcanany
</div>
