<div class="content-wrapper" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Groupe 1</th>
                                @foreach ($weekDates as $date)
                                    <th style="font-size: 10px;" class="text-center"> {{ $date->format('m-d') }} </th>
                                @endforeach
                                <th>Total\S</th>
                                <th>Total\M</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-truncate"><strong>{{ $user->last_name }}
                                            {{ $user->first_name }}</strong></td>
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
                                                    ->where('date_confirm', $date->format('Y-m-d'))
                                                    ->first()->sales_count ?? 0;
                                            $totalSalesCount += $salesCount;
                                            $backgroundColor = $salesCount != 0 ? 'background-color: #5cb85c ; color:white' : '';
                                            $absenceUser = $absence
                                                ->where('user_id', $user->id)
                                                ->where('date', $date->format('Y-m-d'))
                                                ->first();
                                            $resignationUser = $resignation->where('user_id', $user->id)->first();
                                            
                                            $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                            $backgroundColor4 = $resignationUser ? 'background-color: #5A5A5A ; color:#5A5A5A ' : '';
                                            $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                        <td style="border: 4px solid rgb(253, 253, 253);background-color:#ececec ; {{ $backgroundColor }}; border-radius:15px; {{ $backgroundColor2 }}; {{ $backgroundColor4 }};"
                                            class="text-center">
                                            {{ $salesCount }}
                                        </td>
                                    @endforeach
                                    <td class="text-center"
                                        style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                        {{ $totalSalesCount }}</td>
                                    @foreach (fetchMonthDates() as $date)
                                        @php
                                            $carbonDate = Carbon\Carbon::parse($date);
                                            
                                            $salesCount =
                                                $sales
                                                    ->where('user_id', $user->id)
                                                    ->where('date_confirm', $carbonDate->format('Y-m-d'))
                                                    ->first()->sales_count ?? 0;
                                            
                                            $totalSalesCountMonth += $salesCount;
                                            $backgroundColor3 = $totalSalesCountMonth ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                    @endforeach
                                    <td class="text-center"
                                        style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                        {{ $totalSalesCountMonth }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="font-size:14px" style="width: 10px;">Total</th>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach ($weekDates as $date)
                                    @php
                                        $salesCount = $sales->where('date_confirm', $date->format('Y-m-d'))->sum('sales_count');
                                        $grandTotal += $salesCount;
                                        
                                        $backgroundColor4 = $salesCount ? 'background-color: #5c6bc0; color:white' : '';
                                        $backgroundColor3 = $grandTotal ? 'background-color: #5c6bc0; color:white' : '';
                                    @endphp
                                    <td class="text-center"
                                        style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor4 }};">
                                        {{ $salesCount }}</td>
                                @endforeach
                                <td class="text-center"
                                    style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                    {{ $grandTotal }}</td>
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
                                    style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                    {{ $grandTotalMonth }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-borderless" style="width: 10px;">
                        <thead>
                            <tr>
                                <th>Groupe 2</th>
                                @foreach ($weekDates as $date)
                                    <th style="font-size: 10px;" class="text-center">{{ $date->format('m-d') }} </th>
                                @endforeach
                                <th>Total\S</th>
                                <th>Total\M</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users2 as $user2)
                                <tr>
                                    <td><strong>{{ $user2->last_name }} {{ $user2->first_name }}</strong> </td>
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
                                                    ->where('date_confirm', $date->format('Y-m-d'))
                                                    ->first()->sales_count ?? 0;
                                            $backgroundColor = $salesCount != 0 ? 'background-color: #5cb85c ; color:white' : '';
                                            $totalSalesCount += $salesCount;
                                            $dailySalesCounts[] = $salesCount;
                                            $absenceUser = $absence2
                                                ->where('user_id', $user2->id)
                                                ->where('date', $date->format('Y-m-d'))
                                                ->first();
                                            $resignationUser = $resignation2->where('user_id', $user2->id)->first();
                                            
                                            $backgroundColor4 = $resignationUser ? 'background-color: #5A5A5A ; color:#5A5A5A ' : '';
                                            $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                            $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                        <td style="border: 4px solid rgb(253, 253, 253);background-color: #ececec;{{ $backgroundColor }}; border-radius:15px; {{ $backgroundColor2 }};{{ $backgroundColor4 }};"
                                            class="text-center">
                                            {{ $salesCount }}</td>
                                    @endforeach
                                    <td class="text-center"
                                        style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                        {{ $totalSalesCount }}</td>
                                    @foreach (fetchMonthDates() as $date)
                                        @php
                                            $carbonDate = Carbon\Carbon::parse($date);
                                            
                                            $salesCount =
                                                $sales2
                                                    ->where('user_id', $user2->id)
                                                    ->where('date_confirm', $carbonDate->format('Y-m-d'))
                                                    ->first()->sales_count ?? 0;
                                            
                                            $totalSalesCountMonth += $salesCount;
                                            $backgroundColor = $totalSalesCountMonth != 0 ? 'background-color: #5c6bc0; color: white ' : '';
                                        @endphp
                                    @endforeach
                                    <td class="text-center"
                                        style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px; {{ $backgroundColor }};">
                                        {{ $totalSalesCountMonth }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="font-size:14px">Total</th>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach ($weekDates as $date)
                                    @php
                                        $salesCount = $sales2->where('date_confirm', $date->format('Y-m-d'))->sum('sales_count');
                                        $grandTotal += $salesCount;
                                        $backgroundColor3 = $grandTotal ? 'background-color: #5c6bc0; color:white' : '';
                                        $backgroundColor4 = $salesCount ? 'background-color: #5c6bc0; color:white' : '';
                                    @endphp
                                    <td class="text-center"
                                        style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor4 }};">
                                        {{ $salesCount }}</td>
                                @endforeach
                                <td class="text-center"
                                    style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                    {{ $grandTotal }}</td>
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
                                    style="border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                    {{ $grandTotalMonth }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-2 grid-margin">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-borderless" style="font-weight:bold">
                        <thead>
                            <tr>
                                <th class="text-center">Prime</th>
                                <th class="text-center">Challenge</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem; ">1000 P = 1500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">300 P = 200 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem;">1400 P = 2500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">400 P = 300 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem;">1800 P = 3500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">500 P = 400 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem;">1800 P = 3500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">600 P = 500 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem;">2200 P = 4500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">700 P = 600 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem;">2600 P = 5500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">800 P = 700 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem;">3000 P = 6500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">900 P = 800 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="padding: 0.8rem;">2400 P = 7500 Dh</td>
                                <td class="text-center" style="padding: 0.8rem;">1000 P = 900 Dh</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2" style="padding: 0.8rem;">NB : Le Challenge est
                                    plafonné</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="margin-top: 60px; ">
                <img src="/assets/images/slogan.png" alt="">
            </div>
        </div>
    </div>
    <div class="row">
        <div style="float: left;">
            <img src="/assets/images/lh.png" style="padding-left: 270px">
        
            <img src="/assets/images/h2f.png" style="padding-left: 630px; margin-top:-20px">
        </div>
    </div>
    
</div>
