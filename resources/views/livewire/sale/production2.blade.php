<div style="background-color: rgb(218, 213, 213)">
    <br><br><br><br><br><br>
    <div class="text-center">
        <img src="/assets/images/production2.png" alt="" style="height:300px">

    </div>
    <br><br><br><br>
    <div class="content-wrapper" style=" background-color: rgb(218, 213, 213)">
        <div class="row">
            <div class="col-7 grid-margin">
                <div class="card" style="">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="font-size:30px;">Agent</th>
                                    @foreach ($nextWeekDatesWithoutWeekends as $date)
                                        <th style="font-size:30px;" class="text-center">
                                            {{ \Carbon\Carbon::parse($date)->format('d-m') }} </th>
                                    @endforeach
                                    <th style="font-size:35px;" class="text-center">Total Sem.</th>
                                    <th style="font-size:35px;" class="text-center">Confirmé</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users3 as $user3)
                                    <tr>
                                        <td style="font-size: 35px; min-width: 50px; max-width: 250px;"
                                            class="text-truncate">
                                            <strong>{{ $user3->first_name }}</strong>
                                        </td>

                                        @php
                                            $totalSalesCount = 0;
                                            $totalSalesCountMonth = 0;
                                            $dailySalesCounts = [];
                                            $currentDate = now()->toDateString();
                                        @endphp
                                        @foreach ($weekDatesWithoutWeekends as $date)
                                            @php
                                                $salesCount =
                                                    $appoint
                                                        ->where('user_id', $user3->id)
                                                        ->where('date_prise', $date)
                                                        ->count() ?? 0;
                                                
                                                $salesCount0 =
                                                    $appoint
                                                        ->where('user_id', $user3->id)
                                                        ->where('date_prise', now()->toDateString())
                                                        ->count() ?? 0;
                                                
                                                $backgroundColor = $salesCount >= 5 ? 'background-color: #5cb85c' : '';
                                                
                                                $totalSalesCount += $salesCount;
                                                $dailySalesCounts[] = $salesCount;
                                                
                                                $absh2f = $absenceh2f
                                                    ->where('user_id', $user3->id)
                                                    ->where('date', $date)
                                                    ->whereBetween('abs_hours', [6, 8])
                                                    ->first();
                                                
                                                $absenceUserDemi = $absenceh2f
                                                    ->where('user_id', $user3->id)
                                                    ->where('date', $date)
                                                    ->whereBetween('abs_hours', [1, 5])
                                                    ->first();
                                                
                                                $suspension = $suspensionh2f
                                                    ->where('user_id', $user3->id)
                                                    ->where('date_debut', '<=', $date)
                                                    ->where('date_fin', '>=', $date)
                                                    ->first();
                                                
                                                $backgroundColor8 = $suspension ? 'background-color: #d32f2f ;' : '';
                                                
                                                $backgroundColor2 = $absh2f ? 'background-color: #d9534f ' : '';
                                                $backgroundColor6 = $absenceUserDemi ? 'background-color: #d9534f ' : '';
                                                
                                                $resignationUser = $resignationh2f->where('user_id', $user3->id)->first();
                                                $backgroundColor4 = $resignationUser && $date >= $resignationUser->date ? 'background-color: #7d7d7d ;' : '';
                                                
                                                $backgroundColor10 = ($date < $currentDate || $date == $currentDate) && $salesCount == 0 ? 'background-color: #e37b76;' : '';
                                                $finalBackgroundColor = $backgroundColor4 ?: $backgroundColor8 ?: $backgroundColor2 ?: $backgroundColor6 ?: $backgroundColor ?: $backgroundColor10;
                                                $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                                
                                                $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                                
                                            @endphp
                                            <td style="font-size:35px; font-size: 35px ;padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #ececec; border-radius:15px; 
                                               {{ $finalBackgroundColor }}"
                                                class="text-center">
                                                <strong>
                                                    @if ($backgroundColor4)
                                                        ARR
                                                    @elseif ($backgroundColor2)
                                                        ABS
                                                    @elseif ($backgroundColor6)
                                                        1/2 ABS
                                                    @elseif ($backgroundColor8)
                                                        MAP
                                                    @else
                                                        {{ $salesCount }}
                                                    @endif

                                                </strong>
                                            </td>
                                        @endforeach

                                        <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                            <strong>{{ $totalSalesCount }}</strong>
                                        </td>
                                        @foreach (fetchMonthDates() as $date)
                                            @php
                                                
                                                $salesCount =
                                                    $appoint
                                                        ->where('user_id', $user3->id)
                                                        ->where('state', '1')
                                                        ->where('date_confirm', $date)
                                                        ->count() ?? 0;
                                                
                                                $totalSalesCountMonth += $salesCount;
                                                $backgroundColor = $totalSalesCountMonth != 0 ? 'background-color: #5c6bc0; color: white ' : '';
                                            @endphp
                                        @endforeach
                                        <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor }};">
                                            <strong>{{ $totalSalesCountMonth }}</strong>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="font-size:35px">Total</th>
                                    @php
                                        $grandTotal = 0;
                                    @endphp
                                    @foreach ($weekDatesWithoutWeekends as $date)
                                        @php
                                            $salesCount = $appoint->where('date_prise', $date)->count();
                                            $grandTotal += $salesCount;
                                            $backgroundColor3 = $grandTotal ? 'background-color: #5c6bc0; color:white' : '';
                                            $backgroundColor4 = $salesCount ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                        <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor4 }};">
                                            <strong>{{ $salesCount }}</strong>
                                        </td>
                                    @endforeach
                                    <td class="text-center"
                                        style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $grandTotal }}</strong>
                                    </td>
                                    @php
                                        $grandTotalMonth = 0;
                                    @endphp
                                    @foreach (fetchMonthDates() as $date)
                                        @php
                                            $salesCount = $appoint
                                                ->where('state', '1')
                                                ->where('date_confirm', $date)
                                                ->count();
                                            $grandTotalMonth += $salesCount;
                                            $backgroundColor3 = $grandTotalMonth ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                    @endforeach
                                    <td class="text-center"
                                        style="font-size:35px; border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $grandTotalMonth }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-5 grid-margin">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <div class="table-container">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center" style="font-size:35px">Matin</th>
                                            <th class="text-center" style="font-size:35px">Aprèm</th>
                                            <th class="text-center" style="font-size:35px">Soir</th>
                                            <th class="text-center" style="font-size:35px">Total</th>
                                            <th class="text-center" style="font-size:35px">Confirmé</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalConfirme = 0;
                                        @endphp
                                        @foreach ($weekDatesWithoutWeekends as $date)
                                            @php
                                                $isFriday =
                                                    \Carbon\Carbon::parse($date)
                                                        ->locale('fr')
                                                        ->isoFormat('dddd') === 'vendredi';
                                                
                                                $isMonday =
                                                    \Carbon\Carbon::parse($date)
                                                        ->locale('fr')
                                                        ->isoFormat('dddd') === 'lundi';
                                            @endphp
                                            <tr>
                                                <td style="font-size: 35px; font-size: 35px;">
                                                    <strong>{{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D-0M') }}</strong>
                                                </td>
                                                @php
                                                    $rdvCountM =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->whereBetween('cr', ['09:00:00', '12:00:00'])
                                                            ->count() ?? 0;
                                                    $rdvCountA =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->whereBetween('cr', ['12:00:00', '18:00:00'])
                                                            ->count() ?? 0;
                                                    $rdvCountS =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->whereBetween('cr', ['18:00:00', '20:00:00'])
                                                            ->count() ?? 0;
                                                    $rdvCount = $appoint->where('date_rdv', $date)->count() ?? 0;
                                                    $rdvCountConfirme =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->where('state', '1')
                                                            ->count() ?? 0;
                                                    
                                                    $totalConfirme += $rdvCountConfirme;
                                                @endphp
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px; @if ($isFriday) background-color: #444657; color: #444657; @endif; @if ($isMonday) background-color: #444657; color: #444657; @endif">
                                                    <strong>{{ $rdvCountM }} </strong>
                                                </td>
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px; @if ($isFriday) background-color: #444657; color: #444657; @endif">
                                                    <strong>{{ $rdvCountA }}</strong>
                                                </td>
                                                <td class="text-center "
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px; @if ($isFriday) background-color: #444657; color: #444657; @endif">
                                                    <strong>{{ $rdvCountS }}</strong>
                                                </td>
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px;">
                                                    <strong> {{ $rdvCount }}</strong>
                                                </td>
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px;">
                                                    <strong>{{ $rdvCountConfirme }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td></td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px;">
                                            <strong>{{ $totalConfirme }} </strong>
                                        </td>
                                    </tfoot>
                                </table>
    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <div class="table-container">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center" style="font-size:35px">Matin</th>
                                            <th class="text-center" style="font-size:35px">Aprèm</th>
                                            <th class="text-center" style="font-size:35px">Soir</th>
                                            <th class="text-center" style="font-size:35px">Total</th>
                                            <th class="text-center" style="font-size:35px">Confirmé</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalConfirme = 0;
                                        @endphp
                                        @foreach ($nextWeekDatesWithoutWeekends as $date)
                                            @php
                                                $isFriday =
                                                    \Carbon\Carbon::parse($date)
                                                        ->locale('fr')
                                                        ->isoFormat('dddd') === 'vendredi';
                                                
                                                $isMonday =
                                                    \Carbon\Carbon::parse($date)
                                                        ->locale('fr')
                                                        ->isoFormat('dddd') === 'lundi';
                                            @endphp
                                            <tr>
                                                <td style="font-size: 35px;">
                                                    <strong>{{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D-0M') }}</strong>
                                                </td>
                                                @php
                                                    $rdvCountM =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->whereBetween('cr', ['09:00:00', '12:00:00'])
                                                            ->count() ?? 0;
                                                    $rdvCountA =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->whereBetween('cr', ['12:00:00', '18:00:00'])
                                                            ->count() ?? 0;
                                                    $rdvCountS =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->whereBetween('cr', ['18:00:00', '20:00:00'])
                                                            ->count() ?? 0;
                                                    $rdvCount = $appoint->where('date_rdv', $date)->count() ?? 0;
                                                    $rdvCountConfirme =
                                                        $appoint
                                                            ->where('date_rdv', $date)
                                                            ->where('state', '1')
                                                            ->count() ?? 0;
                                                    
                                                    $totalConfirme += $rdvCountConfirme;
                                                @endphp
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px; @if ($isFriday) background-color: #444657; color: #444657; @endif ; @if ($isMonday) background-color: #444657; color: #444657; @endif">
                                                    <strong>{{ $rdvCountM }} </strong>
                                                </td>
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px; @if ($isFriday) background-color: #444657; color: #444657; @endif">
                                                    <strong>{{ $rdvCountA }}</strong>
                                                </td>
                                                <td class="text-center "
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px; @if ($isFriday) background-color: #444657; color: #444657; @endif">
                                                    <strong>{{ $rdvCountS }}</strong>
                                                </td>
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px;">
                                                    <strong>{{ $rdvCount }}</strong>
                                                </td>
                                                <td class="text-center"
                                                    style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px;">
                                                    <strong>{{ $rdvCountConfirme }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td></td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #444657; border-radius:15px;">
                                        </td>
                                        <td class="text-center"
                                            style="font-size: 35px ;border: 4px solid rgb(253, 253, 253);background-color:  #ececec; border-radius:15px;">
                                            <strong>{{ $totalConfirme }} </strong>
                                        </td>
                                    </tfoot>
                                </table>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 grid-margin">
                    <div class="text-center">
                        <img src="/assets/images/lh.png" style="height:400px">
                    </div>
                </div>
                <div class="col-6 grid-margin">
                    <div class="text-center">
                        <img src="/assets/images/h2f.png" style=" height:385px">
                    </div>
                </div>
            </div><br><br><br><br><br><br>
        </div>
    </div>
