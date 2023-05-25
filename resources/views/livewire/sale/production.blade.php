<div class="row">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Agent</th>
                        @foreach ($weekDates as $date)
                            <th style="font-size: 10px;">{{ $date->format('Y-m-d') }} </th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->last_name }} {{ $user->first_name }} </td>
                            @php
                                $totalSalesCount = 0;
                                $dailySalesCounts = [];
                            @endphp
                            @foreach ($weekDates as $date)
                                @php
                                    $salesCount =
                                        $sales
                                            ->where('user_id', $user->id)
                                            ->where('date_sal', $date->format('Y-m-d'))
                                            ->first()->sales_count ?? 0;
                                    $backgroundColor = $salesCount != 0 ? 'background-color: #C9D2FE ' : '';
                                    $totalSalesCount += $salesCount;
                                    $dailySalesCounts[] = $salesCount;
                                @endphp
                                <td style="{{ $backgroundColor }}" class="text-center" >{{ $salesCount }}</td>
                            @endforeach
                            <td class="text-center" >{{ $totalSalesCount }}</td>
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
                                $salesCount = $sales->where('date_sal', $date->format('Y-m-d'))->sum('sales_count');
                                $grandTotal += $salesCount;
                            @endphp
                            <td class="text-center">{{ $salesCount }}</td>
                        @endforeach
                        <td class="text-center">{{ $grandTotal }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
