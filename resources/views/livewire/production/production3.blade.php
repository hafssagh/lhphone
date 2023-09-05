<div style="background-color: rgb(218, 213, 213)">
    <br><br><br><br><br><br><br><br>
    <div class="text-center">
        <img src="/assets/images/production1.png" alt="" style="height:300px">
        {{--   <img src="/assets/images/prod2.png" alt="" style="height:200px">  <img src="/assets/images/prod1.png" alt="" style="height:300px"> --}}
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="content-wrapper" style=" background-color: rgb(218, 213, 213)">
        <div class="row">
            <div class="col-6 grid-margin">
                <div class="card" style="">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="font-size:30px;">Groupe 1</th>
                                    @foreach ($weekDatesWithoutWeekends as $date)
                                        <th style="font-size:30px;" class="text-center">
                                            {{ \Carbon\Carbon::parse($date)->format('d-m') }} </th>
                                    @endforeach
                                    <th style="font-size:35px;" class="text-center">Total Sem.</th>
                                    <th style="font-size:35px;" class="text-center">Confirmé</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users1 as $user1)
                                    <tr>
                                        <td style="font-size: 35px; min-width: 50px; max-width: 250px;"
                                            class="text-truncate">
                                            <strong>{{ $user1->first_name }}</strong>
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
                                                    $renovation1
                                                        ->where('user_id', $user1->id)
                                                        ->where('date_prise', $date)
                                                        ->count() ?? 0;
                                                
                                                $salesCount0 =
                                                    $renovation1
                                                        ->where('user_id', $user1->id)
                                                        ->where('date_prise', now()->toDateString())
                                                        ->count() ?? 0;
                                                
                                                $backgroundColor1 = $salesCount >= 5 ? 'background-color: #2fc22f' : '';
                                                $backgroundColor = $salesCount != 0 ? 'background-color: #a2c493' : '';
    
                                                $totalSalesCount += $salesCount;
                                                $dailySalesCounts[] = $salesCount;
                                                
                                                $absenceUser = $absence
                                                        ->where('user_id', $user1->id)
                                                        ->where('date', $date)
                                                        ->where('abs_hours', '>=', 8)
                                                        ->first();
                                                    
                                                    $absenceUser12 = $absence
                                                        ->where('user_id', $user1->id)
                                                        ->where('date', $date)
                                                        ->whereBetween('abs_hours', [1, 3])
                                                        ->first();
                                                    
                                                    $absenceUserDemi = $absence
                                                        ->where('user_id', $user1->id)
                                                        ->where('date', $date)
                                                        ->whereBetween('abs_hours', [4, 5])
                                                        ->first();
                                                    
                                                    $retard = $absence
                                                        ->where('user_id', $user1->id)
                                                        ->where('date', $date)
                                                        ->where('abs_hours', '<', 1)
                                                        ->first();
                                                    
                                                    $suspension = $suspension1
                                                        ->where('user_id', $user1->id)
                                                        ->where('date_debut', '<=', $date)
                                                        ->where('date_fin', '>=', $date)
                                                        ->first();
                                                    
                                                    $backgroundColor8 = $suspension ? 'background-color: #d32f2f ; color: #d32f2f' : '';
                                                    
                                                    $backgroundColor2 = $absenceUser ? 'background-color: #f0f046 ' : '';
                                                    $backgroundColor5 = $absenceUser12 ? 'background-color: #9EEFF0 ' : '';
                                                    $backgroundColor6 = $absenceUserDemi ? 'background-color: #f59445 ' : '';
                                                    $backgroundColor7 = $retard ? 'background-color: #688dd4 ' : '';
                                                    
                                                    $resignationUser = $resignation1->where('user_id', $user1->id)->first();
                                                    $backgroundColor4 = $resignationUser && $date >= $resignationUser->date ? 'background-color: #5A5A5A ; color: #5A5A5A' : '';
                                                    
                                                    $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                                @endphp
                                                <td style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color:#c4c3c3 ; {{ $backgroundColor }}{{ $backgroundColor1 }}; border-radius:15px;
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
                                                    $renovation1
                                                        ->where('user_id', $user1->id)
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
                                            $salesCount = $renovation1->where('date_prise', $date)->count();
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
                                            $salesCount = $renovation1
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
            <div class="col-6 grid-margin ">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="font-size:30px;">Groupe 2</th>
                                    @foreach ($weekDatesWithoutWeekends as $date)
                                        <th style="font-size:30px;" class="text-center">
                                            {{ \Carbon\Carbon::parse($date)->format('d-m') }} </th>
                                    @endforeach
                                    <th style="font-size:35px;" class="text-center">Total Sem.</th>
                                    <th style="font-size:35px;" class="text-center">Confirmé</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users2 as $user2)
                                    <tr>
                                        <td style="font-size: 35px; min-width: 50px; max-width: 250px;"
                                            class="text-truncate">
                                            <strong>{{ $user2->first_name }}</strong>
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
                                                    $renovation2
                                                        ->where('user_id', $user2->id)
                                                        ->where('date_prise', $date)
                                                        ->count() ?? 0;
                                                
                                                $salesCount0 =
                                                    $renovation2
                                                        ->where('user_id', $user2->id)
                                                        ->where('date_prise', now()->toDateString())
                                                        ->count() ?? 0;
                                                
                                                $backgroundColor1 = $salesCount >= 5 ? 'background-color: #2fc22f' : '';
                                                $backgroundColor = $salesCount != 0 ? 'background-color: #a2c493' : '';
    
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
                                                    
                                                    $resignationUser = $resignation2->where('user_id', $user1->id)->first();
                                                    $backgroundColor4 = $resignationUser && $date >= $resignationUser->date ? 'background-color: #5A5A5A ; color: #5A5A5A' : '';
                                                    
                                                    $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                                @endphp
                                                <td style="font-size:35px;border: 4px solid rgb(253, 253, 253);background-color:#c4c3c3 ; {{ $backgroundColor }}{{ $backgroundColor1 }}; border-radius:15px;
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
                                                    $renovation2
                                                        ->where('user_id', $user2->id)
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
                                            $salesCount = $renovation2->where('date_prise', $date)->count();
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
                                            $salesCount = $renovation2
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
        </div>
        <div class="row">
            <div class="col-6 grid-margin"><br><br><br><br><br><br>
                <div class="text-center">
                    <img src="/assets/images/lh.png" style="height:400px">
                </div>
            </div>
            <div class="col-6 grid-margin"><br><br><br><br><br>
                <div class="text-center">
                    <img src="/assets/images/h2f.png" style=" height:385px">
                </div>
            </div>
        </div><br><br><br><br><br><br><br><br><br><br><br>
    </div>
</div>

<style>
    td.legend {
        padding: 1rem;
        font-size: 30px;
        font-weight: bold
    }
</style>
