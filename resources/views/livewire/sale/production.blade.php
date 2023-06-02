<br>
<div class="row">
    <div class="col-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <table class="table table-bordered" style="width: 10px; ">
                    <thead>
                        <tr>
                            <th>Agent</th>
                            @foreach ($weekDates as $date)
                                <th style="font-size: 10px;" class="text-center">{{ $date->format('m-d') }} </th>
                            @endforeach
                            <th>Total\S</th>
                            <th>Total\M</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-truncate">{{ $user->last_name }} {{ $user->first_name }}</td>
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
                                        $backgroundColor = $salesCount != 0 ? 'background-color: #C9D2FE ' : '';
                                        $absenceUser = $absence
                                            ->where('user_id', $user->id)
                                            ->where('date', $date->format('Y-m-d'))
                                            ->first();
                                        
                                        $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                    @endphp
                                    <td style="{{$backgroundColor }}; {{ $backgroundColor2 }}; width: 10px; " class="text-center">
                                        {{ $salesCount }}</td>
                                @endforeach
                                <td class="text-center">{{ $totalSalesCount }}</td>
                                @foreach (fetchMonthDates() as $date)
                                    @php
                                        $carbonDate = Carbon\Carbon::parse($date);
                                        
                                        $salesCount =
                                            $sales
                                                ->where('user_id', $user->id)
                                                ->where('date_confirm', $carbonDate->format('Y-m-d'))
                                                ->first()->sales_count ?? 0;
                                        
                                        $totalSalesCountMonth += $salesCount;
                                    @endphp
                                @endforeach
                                <td class="text-center" style="width: 10px;">{{ $totalSalesCountMonth }}</td>
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
                                @endphp
                                <td class="text-center">{{ $salesCount }}</td>
                            @endforeach
                            <td class="text-center">{{ $grandTotal }}</td>
                            @php
                                $grandTotalMonth = 0;
                            @endphp
                            @foreach (fetchMonthDates() as $date)
                                @php
                                    $salesCount = $sales->where('date_confirm', $date)->sum('sales_count');
                                    $grandTotalMonth += $salesCount;
                                @endphp
                            @endforeach

                            <td class="text-center">{{ $grandTotalMonth }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <table class="table table-bordered" style="width: 10px;">
                    <thead>
                        <tr>
                            <th>Agent</th>
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
                                <td>{{ $user2->last_name }} {{ $user2->first_name }} </td>
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
                                        $backgroundColor = $salesCount != 0 ? 'background-color: #C9D2FE ' : '';
                                        $totalSalesCount += $salesCount;
                                        $dailySalesCounts[] = $salesCount;
                                        $absenceUser = $absence2
                                            ->where('user_id', $user2->id)
                                            ->where('date', $date->format('Y-m-d'))
                                            ->first();
                                        
                                        $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                    @endphp
                                    <td style="{{ $backgroundColor }}; {{ $backgroundColor2 }}; width: 10px;" class="text-center">
                                        {{ $salesCount }}</td>
                                @endforeach
                                <td class="text-center" style="width: 10px;">{{ $totalSalesCount }}</td>
                                @foreach (fetchMonthDates() as $date)
                                    @php
                                        $carbonDate = Carbon\Carbon::parse($date);
                                        
                                        $salesCount =
                                            $sales2
                                                ->where('user_id', $user2->id)
                                                ->where('date_confirm', $carbonDate->format('Y-m-d'))
                                                ->first()->sales_count ?? 0;
                                        
                                        $totalSalesCountMonth += $salesCount;
                                    @endphp
                                @endforeach
                                <td class="text-center" style="width: 10px;">{{ $totalSalesCountMonth }}</td>
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
                                @endphp
                                <td class="text-center">{{ $salesCount }}</td>
                            @endforeach
                            <td class="text-center">{{ $grandTotal }}</td>
                            @php
                                $grandTotalMonth = 0;
                            @endphp
                            @foreach (fetchMonthDates() as $date)
                                @php
                                    $salesCount = $sales2->where('date_confirm', $date)->sum('sales_count');
                                    $grandTotalMonth += $salesCount;
                                @endphp
                            @endforeach

                            <td class="text-center">{{ $grandTotalMonth }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
