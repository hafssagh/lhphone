
<div>
    <ul class="navbar-nav">
        <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h3 class="text-muted fw-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear-fill"
                    viewBox="0 0 16 16">
                    <path
                        d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                </svg>
                <i>&nbsp; En cours de construction ... </i>
            </h3>
        </li>
    </ul>
    <br><br>  
        <div class="row">
            <div class="col-sm-12">
                <div class="row mb-3">
                  {{--   @can('superadmin')
                    <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 style="color:#4650dd  font-size: 1.25rem">{{ $cards[0] }} Agents</h3>
                                        <p class="text-sm mb-0">Groupe Chris Ezzahra</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                            fill="currentColor" class="bi bi-1-circle" viewBox="0 0 16 16"
                                            style="color: #4650dd">
                                            <path
                                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #dadcf8;border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center  justify-content-center" style="color:#4650dd ">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="{{ route('users.index') }}"
                                                    style="text-decoration: none;color: inherit;">En savoir
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
                                        <h3 class="text-danger" style=" font-size: 1.25rem">{{ $cards[1] }} Agents</h3>
                                        <p class="text-sm mb-0">Groupe Amine</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                            fill="currentColor" class="bi bi-1-circle" viewBox="0 0 16 16"
                                            style="color:#dc3545">
                                            <path
                                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM6.646 6.24v.07H5.375v-.064c0-1.213.879-2.402 2.637-2.402 1.582 0 2.613.949 2.613 2.215 0 1.002-.6 1.667-1.287 2.43l-.096.107-1.974 2.22v.077h3.498V12H5.422v-.832l2.97-3.293c.434-.475.903-1.008.903-1.705 0-.744-.557-1.236-1.313-1.236-.843 0-1.336.615-1.336 1.306Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #ffe2e0; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center justify-content-center text-danger">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="{{ route('users.index') }}"
                                                    style="text-decoration: none;color: inherit;">En savoir
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
                    @endcan --}}
                    <div class="mb-4 col-sm-6 col-lg-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 style="color:#4650dd; font-size: 1.25rem" >{{$cards[7]}} Propositions</h3>
                                        <p class="text-sm mb-0">Envoyés Aujourd'hui</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar2-event" viewBox="0 0 16 16">
                                            <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" style="color: #4650dd"/>
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" style="color: #4650dd"/>
                                            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"style="color: #4650dd"/>
                                          </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #dadcf8;border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center  justify-content-center" style="color:#4650dd ">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="/customer/proposal"
                                                    style="text-decoration: none;color: inherit;">En savoir
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
                                        <h3 class="text-danger" style="font-size: 1.25rem">{{$cards[8]}} Propositions</h3>
                                        <p class="text-sm mb-0">Non traitées</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar-x" viewBox="0 0 16 16">
                                            <path style="color:#dc3545" d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z"/>
                                            <path style="color:#dc3545" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                          </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #ffe2e0; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center justify-content-center text-danger">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="/proposal/week"
                                                    style="text-decoration: none;color: inherit;">En savoir
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
                                        <h3 style="color:#66bb6a; font-size: 1.25rem">{{ $cards[2] }} Confirmés</h3>
                                        <p class="text-sm mb-0">Aujourd'hui</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar2-check" viewBox="0 0 16 16">
                                            <path style="color:#66bb6a" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                            <path style="color:#66bb6a" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                                            <path style="color:#66bb6a" d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                                          </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #c8e6c9; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center justify-content-center" style="color:#66bb6a">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="{{ route('sales.index') }}"
                                                    style="text-decoration: none;color: inherit;">En savoir
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
                                        <h3 style="color:#835db4; font-size: 1.25rem">{{ $cards[3] }} Devis</h3>
                                        <p class="text-sm mb-0">En cours de traitement</p>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                        <path style="color:#835db4" d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        <path style="color:#835db4" d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                      </svg>
                                </div>
                            </div>
                            <div class="card-footer py-3"
                                style="background-color: #ddd6e7; border-radius:  0 0 1rem 1rem; border-color: transparent;">
                                <div class="row align-items-center justify-content-center" style="color:#835db4">
                                    <div class="col-10">
                                        <p class="mb-0">
                                            <strong><a href="{{ route('sales.index') }}"
                                                    style="text-decoration: none;color: inherit;">En savoir
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
            <div class="mb-4 col-sm-6 col-md-8 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h3 class="card-title" >Ventes de l'année</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4 col-sm-6 col-md-4 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h3 class="card-title">Devis du mois</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" style="margin-top: 20px">
                            <canvas id="doughnutChart" wire:ignore></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <div class="table">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="padding: 0.8rem;">Agent</th>
                            <th style="padding: 0.8rem;" class="text-center">Absence</th>
                            <th style="padding: 0.8rem;" class="text-center">Heures travail</th>
                            <th style="padding: 0.8rem;" class="text-center">Salaire fixe</th>
                            <th style="padding: 0.8rem;" class="text-center">Salaire</th>
                            <th style="padding: 0.8rem;" class="text-center">Vente(Sem)</th>
                            <th style="padding: 0.8rem;" class="text-center">Challenge</th>
                            <th style="padding: 0.8rem;" class="text-center">Vente(Mois)</th>
                            <th style="padding: 0.8rem;" class="text-center">Prime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td style="padding: 0.8rem;"> {{ $user->last_name }} {{ $user->first_name }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->absenceHours }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->work_hours }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->base_salary }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->salary }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->sumQuantity }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->challenge ?? 0 }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->sumQuantity2 }}</td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->prime ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" style="padding: 0.8rem;"><strong>Total</strong></td>
                            <td style="padding: 0.8rem;"></td>
                            <td style="padding: 0.8rem;"></td>
                            <td style="padding: 0.8rem;" class="text-center"><strong>{{ $sumValues[1] }} DH</strong>
                            </td>
                            <td style="padding: 0.8rem;" class="text-center"><strong>{{ $sumValues[0] }} DH</strong>
                            </td>
                            <td style="padding: 0.8rem;" class="text-center"><strong>{{ $sumValues[4] }} P</strong>
                            </td>
                            <td style="padding: 0.8rem;" class="text-center"><strong>{{ $sumValues[2] }} DH</strong>
                            </td>
                            <td style="padding: 0.8rem;" class="text-center"><strong>{{ $sumValues[5] }} P</strong>
                            </td>
                            <td style="padding: 0.8rem;" class="text-center"><strong>{{ $sumValues[3] }} DH</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="float-end">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("livewire:load", function() {
        var ctx = document.getElementById('doughnutChart').getContext('2d');
        var doughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: @json($chartData),
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
                cutout: 90
            }
        });
    });
</script>


<script>
    document.addEventListener('livewire:load', function() {
        var months = @json($months);
        var refusedSales = @json($refusedSales);
        var acceptedSales = @json($acceptedSales);

        var ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                        label: 'Acceptées',
                        data: acceptedSales,
                        type: 'line',
                        borderColor: '#4650dd ',
                        backgroundColor: '#4650dd ',
                    },
                    {
                        label: 'Refusées',
                        data: refusedSales,
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
