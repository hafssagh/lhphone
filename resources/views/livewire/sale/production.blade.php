<div style="background-color: rgb(218, 213, 213)">
    <br><br><br><br><br><br><br><br>
    <div class="text-center">
        <img src="/assets/images/production1.png" alt="" style="height:300px">
        {{--   <img src="/assets/images/prod2.png" alt="" style="height:200px">  <img src="/assets/images/prod1.png" alt="" style="height:300px"> --}}
    </div>
    <br><br><br><br><br><br>
    <div class="content-wrapper" style=" background-color: rgb(218, 213, 213)">
        <div class="row">
            <div class="col-6 grid-margin">
                <div class="card" style="">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="font-size:30px;">Groupe 1</th>
                                    @foreach ($weekDates as $date)
                                        <th style="font-size:30px;" class="text-center">
                                            {{ \Carbon\Carbon::parse($date)->format('d-m') }} </th>
                                    @endforeach
                                    <th style="font-size:35px;">Total\S</th>
                                    <th style="font-size:35px;">Total\M</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="font-size: 35px; min-width: 50px; max-width: 250px;"
                                            class="text-truncate">
                                            <strong>{{ $user->first_name }}</strong>
                                        </td>

                                        @php
                                            $totalSalesCount = 0;
                                            $totalSalesCountMonth = 0;
                                            $dailySalesCounts = [];
                                        @endphp
                                        @foreach ($weekDates as $date)
                                            @php
                                                $salesCount =
                                                    $sales
                                                        ->where('user_id', $user->id)
                                                        ->where('date_confirm', $date)
                                                        ->first()->sales_count ?? 0;
                                                $totalSalesCount += $salesCount;
                                                $backgroundColor = $salesCount != 0 ? 'background-color: #93c47d' : '';
                                                
                                                $absenceUser = $absence
                                                    ->where('user_id', $user->id)
                                                    ->where('date', $date)
                                                    ->where('abs_hours', '>=', 8)
                                                    ->first();
                                                
                                                $absenceUser12 = $absence
                                                    ->where('user_id', $user->id)
                                                    ->where('date', $date)
                                                    ->whereBetween('abs_hours', [1, 3])
                                                    ->first();
                                                
                                                $absenceUserDemi = $absence
                                                    ->where('user_id', $user->id)
                                                    ->where('date', $date)
                                                    ->whereBetween('abs_hours', [4, 5])
                                                    ->first();
                                                
                                                $retard = $absence
                                                    ->where('user_id', $user->id)
                                                    ->where('date', $date)
                                                    ->where('abs_hours', '<', 1)
                                                    ->first();
                                                
                                                $suspension = $suspension1
                                                    ->where('user_id', $user->id)
                                                    ->where('date_debut', '<=', $date)
                                                    ->where('date_fin', '>=', $date)
                                                    ->first();
                                                
                                                $backgroundColor8 = $suspension ? 'background-color: #d32f2f ; color: #d32f2f' : '';
                                                
                                                $backgroundColor2 = $absenceUser ? 'background-color: #f0f046 ' : '';
                                                $backgroundColor5 = $absenceUser12 ? 'background-color: #9EEFF0 ' : '';
                                                $backgroundColor6 = $absenceUserDemi ? 'background-color: #f59445 ' : '';
                                                $backgroundColor7 = $retard ? 'background-color: #688dd4 ' : '';
                                                
                                                $resignationUser = $resignation->where('user_id', $user->id)->first();
                                                $backgroundColor4 = $resignationUser && $date >= $resignationUser->date ? 'background-color: #5A5A5A ; color: #5A5A5A' : '';
                                                
                                                $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                            @endphp
                                            <td style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color:#c4c3c3 ; {{ $backgroundColor }}; border-radius:15px;
                                         {{ $backgroundColor2 }}; {{ $backgroundColor4 }}; {{ $backgroundColor5 }}; {{ $backgroundColor6 }}; {{ $backgroundColor7 }}; {{ $backgroundColor8 }}"
                                                class="text-center">
                                                <strong>{{ $salesCount }}</strong>
                                            </td>
                                        @endforeach
                                        <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                            <strong>{{ $totalSalesCount }}</strong>
                                        </td>
                                        @foreach (fetchMonthDates() as $date)
                                            @php
                                                $salesCount =
                                                    $sales
                                                        ->where('user_id', $user->id)
                                                        ->where('date_confirm', $date)
                                                        ->first()->sales_count ?? 0;
                                                
                                                $totalSalesCountMonth += $salesCount;
                                                $backgroundColor3 = $totalSalesCountMonth ? 'background-color: #5c6bc0; color:white' : '';
                                            @endphp
                                        @endforeach
                                        <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
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
                                    @foreach ($weekDates as $date)
                                        @php
                                            $salesCount = $sales->where('date_confirm', $date)->sum('sales_count');
                                            $grandTotal += $salesCount;
                                            
                                            $backgroundColor4 = $salesCount ? 'background-color: #5c6bc0; color:white' : '';
                                            $backgroundColor3 = $grandTotal ? 'background-color: #5c6bc0; color:white' : '';
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
                                            $salesCount = $sales->where('date_confirm', $date)->sum('sales_count');
                                            $grandTotalMonth += $salesCount;
                                            $backgroundColor3 = $grandTotalMonth ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                    @endforeach

                                    <td class="text-center"
                                        style="font-size:35px; border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $grandTotalMonth }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="font-size:35px; ">Reste</th>
                                    @foreach ($weekDates as $date)
                                        <td style="font-size:35px; border: 4px solid rgb(253, 253, 253); background-color: #cccbcb; border-radius: 15px;"
                                            class="text-center">
                                            @foreach ($objectiveA as $obj)
                                                @php
                                                    $dayOfWeek = Carbon\Carbon::parse($date)->dayOfWeek;
                                                    if ($dayOfWeek === Carbon\Carbon::SATURDAY || $dayOfWeek === Carbon\Carbon::SUNDAY) {
                                                        $reste = 0;
                                                    } else {
                                                        $salesCount = $sales->where('date_confirm', $date)->sum('sales_count');
                                                        $object = $obj->objective;
                                                        $reste = $object - $salesCount;
                                                    }
                                                @endphp
                                                <strong>{{ $reste }}</strong>
                                            @endforeach
                                        </td>
                                    @endforeach
                                    <td class="text-center"
                                        style="font-size:35px; border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
                                        @foreach ($weekDates as $date)
                                            @php
                                                $dayOfWeek = Carbon\Carbon::parse($date)->dayOfWeek;
                                                if ($dayOfWeek === Carbon\Carbon::SATURDAY || $dayOfWeek === Carbon\Carbon::SUNDAY) {
                                                    $reste = 0;
                                                } else {
                                                    $salesCount = $sales->where('date_confirm', $date)->sum('sales_count');
                                                }
                                            @endphp
                                        @endforeach
                                        @php
                                            $salesCount = $sales->where('date_confirm', $date)->sum('sales_count');
                                            $grandTotal += $salesCount;
                                            $object = $obj->objective;
                                            $remainingDaysCount = count($weekDates) - 2;
                                            $total = $object * $remainingDaysCount;
                                            $restTotal = $total - $grandTotal;
                                        @endphp
                                        <strong>{{ $restTotal }}</strong>
                                    </td>
                                    <td class="text-center"
                                        style="font-size:35px; border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6 grid-margin ">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="font-size:30px;">Groupe 2</th>
                                    @foreach ($weekDates as $date)
                                        <th style="font-size: 30px;" class="text-center">
                                            {{ \Carbon\Carbon::parse($date)->format('d-m') }}</th>
                                    @endforeach
                                    {{-- <th style="font-size:30px;" class="text-center">Objectif</th> --}}
                                    <th style="font-size:35px;">Total\S</th>
                                    <th style="font-size:35px;">Total\M</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users2 as $user2)
                                    <tr>
                                        <td style="font-size: 35px; min-width: 50px; max-width: 200px;"
                                            class="text-truncate">
                                            <strong>{{ $user2->first_name }}</strong>
                                        </td>
                                        @php
                                            $totalSalesCount = 0;
                                            $totalSalesCountMonth = 0;
                                            $dailySalesCounts = [];
                                        @endphp
                                        @foreach ($weekDates as $date)
                                            @php
                                                $salesCount =
                                                    $sales2
                                                        ->where('user_id', $user2->id)
                                                        ->where('date_confirm', $date)
                                                        ->first()->sales_count ?? 0;
                                                $backgroundColor = $salesCount != 0 ? 'background-color: #5cb85c ;' : '';
                                                $totalSalesCount += $salesCount;
                                                $dailySalesCounts[] = $salesCount;
                                                
                                                $absenceUser = $absence2
                                                    ->where('user_id', $user2->id)
                                                    ->where('date', $date)
                                                    ->where('abs_hours', '>=', 8)
                                                    ->first();
                                                
                                                $absenceUser12 = $absence2
                                                    ->where('user_id', $user2->id)
                                                    ->where('date', $date)
                                                    ->whereBetween('abs_hours', [1, 3])
                                                    ->first();
                                                
                                                $absenceUserDemi = $absence2
                                                    ->where('user_id', $user2->id)
                                                    ->where('date', $date)
                                                    ->whereBetween('abs_hours', [4, 5])
                                                    ->first();
                                                
                                                $retard = $absence2
                                                    ->where('user_id', $user2->id)
                                                    ->where('date', $date)
                                                    ->where('abs_hours', '<', 1)
                                                    ->first();
                                                
                                                $suspension = $suspension2
                                                    ->where('user_id', $user2->id)
                                                    ->where('date_debut', '<=', $date)
                                                    ->where('date_fin', '>=', $date)
                                                    ->first();
                                                
                                                $backgroundColor8 = $suspension ? 'background-color: #d32f2f ; color: #d32f2f' : '';
                                                
                                                $backgroundColor2 = $absenceUser ? 'background-color: #f0f046 ' : '';
                                                $backgroundColor5 = $absenceUser12 ? 'background-color: #9EEFF0 ' : '';
                                                $backgroundColor6 = $absenceUserDemi ? 'background-color: #f59445 ' : '';
                                                $backgroundColor7 = $retard ? 'background-color: #688dd4 ' : '';
                                                
                                                $resignationUser = $resignation2->where('user_id', $user2->id)->first();
                                                $backgroundColor4 = $resignationUser && $date >= $resignationUser->date ? 'background-color: #5A5A5A; color: #5A5A5A ' : '';
                                                
                                                $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                            @endphp
                                            <td style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #c4c3c3;{{ $backgroundColor }}; border-radius:15px;
                                         {{ $backgroundColor2 }};{{ $backgroundColor4 }};{{ $backgroundColor5 }};{{ $backgroundColor6 }};{{ $backgroundColor7 }}; {{ $backgroundColor8 }}"
                                                class="text-center">
                                                <strong>{{ $salesCount }}</strong>
                                            </td>
                                        @endforeach
                                        {{--  <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #dbd9d9; border-radius:15px;">
                                            <strong>{{ $user2->objectif }}</strong>
                                        </td> --}}
                                        <td class="text-center"
                                            style="font-size:35px; border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                            <strong>{{ $totalSalesCount }}</strong>
                                        </td>
                                        @foreach (fetchMonthDates() as $date)
                                            @php
                                                
                                                $salesCount =
                                                    $sales2
                                                        ->where('user_id', $user2->id)
                                                        ->where('date_confirm', $date)
                                                        ->first()->sales_count ?? 0;
                                                
                                                $totalSalesCountMonth += $salesCount;
                                                $backgroundColor = $totalSalesCountMonth != 0 ? 'background-color: #5c6bc0; color: white ' : '';
                                            @endphp
                                        @endforeach
                                        <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px; {{ $backgroundColor }};">
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
                                    @foreach ($weekDates as $date)
                                        @php
                                            $salesCount = $sales2->where('date_confirm', $date)->sum('sales_count');
                                            $grandTotal += $salesCount;
                                            $backgroundColor3 = $grandTotal ? 'background-color: #5c6bc0; color:white' : '';
                                            $backgroundColor4 = $salesCount ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                        <td class="text-center"
                                            style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor4 }};">
                                            <strong>{{ $salesCount }}</strong>
                                        </td>
                                    @endforeach
                                    {{--     <td
                                        style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;">
                                    </td> --}}
                                    <td class="text-center"
                                        style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $grandTotal }}</strong>
                                    </td>
                                    @php
                                        $grandTotalMonth = 0;
                                    @endphp
                                    @foreach (fetchMonthDates() as $date)
                                        @php
                                            $salesCount = $sales2->where('date_confirm', $date)->sum('sales_count');
                                            $grandTotalMonth += $salesCount;
                                            $backgroundColor3 = $grandTotalMonth ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                    @endforeach

                                    <td class="text-center"
                                        style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color: #a1a9da; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $grandTotalMonth }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="font-size:35px; ">Reste</th>
                                    @foreach ($weekDates as $date)
                                        <td style="font-size:35px; border: 4px solid rgb(253, 253, 253); background-color: #cccbcb; border-radius: 15px;"
                                            class="text-center">
                                            @foreach ($objectiveB as $obj)
                                                @php
                                                    $dayOfWeek = Carbon\Carbon::parse($date)->dayOfWeek;
                                                    if ($dayOfWeek === Carbon\Carbon::SATURDAY || $dayOfWeek === Carbon\Carbon::SUNDAY) {
                                                        $reste = 0;
                                                    } else {
                                                        $salesCount = $sales2->where('date_confirm', $date)->sum('sales_count');
                                                        $object = $obj->objective;
                                                        $reste = $object - $salesCount;
                                                    }
                                                @endphp
                                                <strong>{{ $reste }}</strong>
                                            @endforeach
                                        </td>
                                    @endforeach
                                    {{--   <td class="text-center"
                                        style=" border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
                                    </td> --}}
                                    <td class="text-center"
                                        style=" font-size:35px; border: 4px solid rgb(253, 253, 253); background-color: #cccbcb; border-radius: 15px;">
                                        @foreach ($weekDates as $date)
                                            @php
                                                $dayOfWeek = Carbon\Carbon::parse($date)->dayOfWeek;
                                                if ($dayOfWeek === Carbon\Carbon::SATURDAY || $dayOfWeek === Carbon\Carbon::SUNDAY) {
                                                    $reste = 0;
                                                } else {
                                                    $salesCount = $sales->where('date_confirm', $date)->sum('sales_count');
                                                }
                                            @endphp
                                        @endforeach
                                        @php
                                            $salesCount = $sales2->where('date_confirm', $date)->sum('sales_count');
                                            $grandTotal += $salesCount;
                                            $object = $obj->objective;
                                            $remainingDaysCount = count($weekDates) - 2;
                                            $total = $object * $remainingDaysCount;
                                            $restTotal = $total - $grandTotal;
                                        @endphp
                                        <strong>{{ $total }}</strong>
                                    </td>

                                    <td class="text-center"
                                        style=" font-size:35px; border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-2 grid-margin">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-center" style=" font-size: 30px; font-weight:bold">Prime</th>
                                    <th class="text-center" style=" font-size: 30px; font-weight:bold">Challenge</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center legend">1000 P = 1500 Dh</td>
                                    <td class="text-center legend">300 P = 200 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend">1400 P = 2500 Dh</td>
                                    <td class="text-center legend">400 P = 300 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend">2000 P = 3500 Dh</td>
                                    <td class="text-center legend">500 P = 400 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend">2000 P = 3500 Dh</td>
                                    <td class="text-center legend">600 P = 500 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend">2200 P = 4500 Dh</td>
                                    <td class="text-center legend">700 P = 600 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend">2600 P = 5500 Dh</td>
                                    <td class="text-center legend">800 P = 700 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend">3000 P = 6500 Dh</td>
                                    <td class="text-center legend">900 P = 800 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend">2400 P = 7500 Dh</td>
                                    <td class="text-center legend">1000 P = 900 Dh</td>
                                </tr>
                                <tr>
                                    <td class="text-center legend" colspan="2">
                                        NB : Le Challenge est plafonné
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><br><br><br>
                <div class="text-center">
                    <img src="/assets/images/slogan.png" style=" height:300px;">
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-6 grid-margin"><br><br><br><br><br>
                <div class="text-center">
                    <img src="/assets/images/lh.png" style="height:400px">
                </div>
            </div>
            <div class="col-6 grid-margin"><br><br><br><br><br>
                <div class="text-center">
                    <img src="/assets/images/h2f.png" style=" height:385px">
                </div>
            </div>
        </div><br><br><br><br><br><br><br><br>
    </div>
</div>

<style>
    td.legend {
        padding: 1rem;
        font-size: 30px;
        font-weight: bold
    }
</style>
