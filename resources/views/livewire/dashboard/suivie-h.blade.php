<div>
    <br>
    <div class="col-sm-12">
        <div class="home-tab">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link ps-0" href="/dashboard2" role="tab" aria-controls="overview"
                            aria-selected="false">Général</a>
                    </li>
                    @can('superadmin')
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboardRH" role="tab" aria-selected="false">Ressources
                                humaines</a>
                        </li>
                    @endcan
                    <li class="nav-item ">
                        <a class="nav-link active" href="/dashboardF" role="tab" aria-selected="true">Suivi
                            Agent</a>
                    </li>
                </ul>
                @can('superadmin')
                    <div>
                        <div class="btn-wrapper" style="margin-top:5px">
                            <a href="/dashboardF" class="btn btn-otline-dark me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    class="bi bi-bar-chart" viewBox="0 0 16 16">
                                    <path
                                        d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
                                </svg> Propositions </a>
                            <a href="/dashboardV" class="btn btn-otline-dark me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    class="bi bi-bar-chart" viewBox="0 0 16 16">
                                    <path
                                        d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
                                </svg> Ventes </a>
                            <a href="/dashboardH" class="btn btn-primary text-white me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z" />
                                </svg>
                                Rendez-vous</a>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="mb-4 col-sm-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">1<sup>ère</sup> semaine</h4>
                    <canvas id="chart1" style="height: 80%; width:50%"></canvas>
                </div>
            </div>
        </div>
        <div class="mb-4 col-sm-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">2<sup>ème</sup> semaine</h4>
                    <canvas id="chart2" style="height: 80%; width:50%"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mb-4 col-sm-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">3<sup>ème</sup> semaine</h4>
                    <canvas id="chart3" style="height: 80%; width:50%"></canvas>
                </div>
            </div>
        </div>
        <div class="mb-4 col-sm-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">4<sup>ème</sup> semaine</h4>
                    <canvas id="chart4" style="height: 80%; width:50%"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mb-4 col-sm-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">5<sup>ème</sup> semaine</h4>
                    <canvas id="chart5" style="height: 80%; width:50%"></canvas>
                </div>
            </div>
        </div>
        <div class="mb-4 col-sm-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="moisAnnee"></h4>
                    <canvas id="chart6" style="height: 80%; width:50%"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function() {
        var ctx1 = document.getElementById('chart1').getContext('2d');
        var ctx2 = document.getElementById('chart2').getContext('2d');
        var ctx3 = document.getElementById('chart3').getContext('2d');
        var ctx4 = document.getElementById('chart4').getContext('2d');
        var ctx5 = document.getElementById('chart5').getContext('2d');

        var datasets = {!! json_encode($weeklyPropo) !!};

        datasets.forEach(function(dataset, index) {
            var weekStart = dataset.week.start;
            var weekEnd = dataset.week.end;
            var labels = dataset.data.map(function(data) {
                return data.name;
            });
            var propoData = dataset.data.map(function(data) {
                return data.propo;
            });
            var propoAcceptData = dataset.data.map(function(data) {
                return data.propoAccept;
            });
            var ctx = eval('ctx' + (index + 1));

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Total rendez-cous',
                            data: propoData,
                            backgroundColor: '#e0e0e0',
                            borderColor: '#c2c0c0',
                            barThickness: 15,
                            borderWidth: 2,
                            borderRadius: 20,
                            borderSkipped: false,
                        },
                        {
                            label: 'Confirmé',
                            data: propoAcceptData,
                            backgroundColor: '#D6EAF8',
                            borderColor: '#AED6F1',
                            barThickness: 15,
                            borderWidth: 2,
                            borderRadius: 20,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            padding: {
                                top: 10,
                                bottom: 10
                            }
                        }
                    }
                },
            });
        });
    });
</script>

<script>
    document.addEventListener('livewire:load', function() {
        var ctx = document.getElementById('chart6').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($users->pluck('first_name')) !!},
                datasets: [{
                        label: 'Total Poposition',
                        data: {!! json_encode($users->pluck('propo_count')) !!},
                        backgroundColor: '#FCF3CF',
                        borderColor: '#F9E79F',
                        barThickness: 15,
                        borderWidth: 2,
                        borderRadius: 20,
                        borderSkipped: false,
                    },
                    {
                        label: 'Confirmé',
                        data: {!! json_encode($users->pluck('propo_count1')) !!},
                        backgroundColor: '#D6EAF8',
                        borderColor: '#AED6F1',
                        barThickness: 15,
                        borderWidth: 2,
                        borderRadius: 20,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            },
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var date = new Date();
        var mois = date.toLocaleString("default", {
            month: "long"
        });
        var annee = date.getFullYear();
        var moisAnnee = mois + " " + annee;

        document.getElementById("moisAnnee").textContent = moisAnnee;
    });
</script>
