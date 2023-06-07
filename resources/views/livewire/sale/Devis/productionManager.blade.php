<div class="row">
    <div class="card">
        <div class="card-body d-flex justify-content-center">
            <table class="table table-borderless" style="width: 10px; ">
                <thead>
                    <tr>
                        <th style="width: 10px; ">Groupe 1</th>
                        @foreach ($weekDates as $date)
                            <th style="font-size: 11px;" class="text-center"> {{ $date->format('Y-m-d') }} </th>
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
</div><br>
<div class="row">
    <div class="card">
        <div class="card-body d-flex justify-content-center">
            <table class="table table-borderless" style="width: 10px;">
                <thead>
                    <tr>
                        <th>Groupe 2</th>
                        @foreach ($weekDates as $date)
                            <th style="font-size: 11px;" class="text-center">{{ $date->format('Y-m-d') }} </th>
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
