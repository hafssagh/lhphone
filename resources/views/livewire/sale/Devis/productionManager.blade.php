 @auth
    @if (Auth::user()->last_name === 'Bélanger' ||
            Auth::user()->last_name === 'EL MESSIOUI' ||
            Auth::user()->last_name === 'ELMOURABIT')
        <div class="row">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 10px; ">Groupe 1</th>
                                @foreach ($weekDates as $date)
                                    <th style="font-size: 11px;" class="text-center">
                                        {{ \Carbon\Carbon::parse($date)->format('m-d') }} </th>
                                @endforeach
                                <th>Total\S</th>
                                <th>Total\M</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td style="padding: 0.7rem" class="text-truncate"><strong>{{ $user->last_name }}
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
                                                    ->where('date_confirm', $date)
                                                    ->first()->sales_count ?? 0;
                                            $totalSalesCount += $salesCount;
                                            $backgroundColor = $salesCount != 0 ? 'background-color: #5cb85c ; color:white' : '';
                                            
                                            $absenceUser = $absence
                                                ->where('user_id', $user->id)
                                                ->where('date', $date)
                                                ->where('abs_hours', '>', 4)
                                                ->first();
                                            
                                            $absenceUser12 = $absence
                                                ->where('user_id', $user->id)
                                                ->where('date', $date)
                                                ->whereBetween('abs_hours', [1, 3])
                                                ->first();
                                            
                                            $absenceUserDemi = $absence
                                                ->where('user_id', $user->id)
                                                ->where('date', $date)
                                                ->where('abs_hours', 4)
                                                ->first();
                                            
                                            $retard = $absence
                                                ->where('user_id', $user->id)
                                                ->where('date', $date)
                                                ->where('abs_hours', -1)
                                                ->first();
                                            
                                            $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                            $backgroundColor5 = $absenceUser12 ? 'background-color: #9EEFF0 ' : '';
                                            $backgroundColor6 = $absenceUserDemi ? 'background-color: #FED071 ' : '';
                                            $backgroundColor7 = $retard ? 'background-color: #A6B9FF ' : '';
                                            
                                            $resignationUser = $resignation->where('user_id', $user->id)->first();
                                            $backgroundColor4 = $resignationUser ? 'background-color: #5A5A5A ; color:#5A5A5A ' : '';
                                            
                                            $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                        <td style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color:#ececec ; {{ $backgroundColor }}; border-radius:15px; 
                                {{ $backgroundColor2 }}; {{ $backgroundColor4 }}; {{ $backgroundColor5 }}; {{ $backgroundColor6 }}; {{ $backgroundColor7 }};"
                                            class="text-center">
                                            <strong>{{ $salesCount }}</strong>
                                        </td>
                                    @endforeach
                                    <td class="text-center"
                                        style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $totalSalesCount }}</strong>
                                    </td>
                                    @foreach (fetchMonthDates() as $date)
                                        @php
                                            $carbonDate = Carbon\Carbon::parse($date);
                                            
                                            $salesCount =
                                                $sales
                                                    ->where('user_id', $user->id)
                                                    ->where('date_confirm', $carbonDate)
                                                    ->first()->sales_count ?? 0;
                                            
                                            $totalSalesCountMonth += $salesCount;
                                            $backgroundColor3 = $totalSalesCountMonth ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                    @endforeach
                                    <td class="text-center"
                                        style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $totalSalesCountMonth }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="font-size:15px; padding: 0.8rem">Total</th>
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
                                        style="padding: 0.7rem ;border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor4 }};">
                                        <strong>{{ $salesCount }}</strong>
                                    </td>
                                @endforeach
                                <td class="text-center"
                                    style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
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
                                    style="padding: 0.7rem ;border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                    <strong>{{ $grandTotalMonth }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div><br>
    @endif
@endauth
@auth
    @if (Auth::user()->last_name === 'Essaid' || Auth::user()->last_name === 'EL MESSIOUI')
        <div class="row">
            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Groupe 2</th>
                                @foreach ($weekDates as $date)
                                    <th style="font-size: 11px;" class="text-center">
                                        {{ \Carbon\Carbon::parse($date)->format('m-d') }}</th>
                                @endforeach
                                <th>Objectif</th>
                                <th>Total\S</th>
                                <th>Total\M</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users2 as $user2)
                                <tr>
                                    <td style="padding: 0.5rem"><strong>{{ $user2->last_name }} {{ $user2->first_name }}</strong> </td>
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
                                            $backgroundColor = $salesCount != 0 ? 'background-color: #5cb85c ; color:white' : '';
                                            $totalSalesCount += $salesCount;
                                            $dailySalesCounts[] = $salesCount;
                                            
                                            $absenceUser = $absence2
                                                ->where('user_id', $user2->id)
                                                ->where('date', $date)
                                                ->where('abs_hours', '>', 4)
                                                ->first();
                                            
                                            $absenceUser12 = $absence2
                                                ->where('user_id', $user2->id)
                                                ->where('date', $date)
                                                ->whereBetween('abs_hours', [1, 3])
                                                ->first();
                                            
                                            $absenceUserDemi = $absence2
                                                ->where('user_id', $user2->id)
                                                ->where('date', $date)
                                                ->where('abs_hours', 4)
                                                ->first();
                                            
                                            $retard = $absence2
                                                ->where('user_id', $user2->id)
                                                ->where('date', $date)
                                                ->where('abs_hours', -1)
                                                ->first();
                                            
                                            $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                            $backgroundColor5 = $absenceUser12 ? 'background-color: #9EEFF0 ' : '';
                                            $backgroundColor6 = $absenceUserDemi ? 'background-color: #FED071 ' : '';
                                            $backgroundColor7 = $retard ? 'background-color: #A6B9FF ' : '';
                                            
                                            $resignationUser = $resignation2->where('user_id', $user2->id)->first();
                                            $backgroundColor4 = $resignationUser ? 'background-color: #5A5A5A ; color:#5A5A5A ' : '';
                                            
                                            $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                        @endphp
                                        <td style="padding: 0.5rem ;padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #ececec; {{ $backgroundColor }}; border-radius:15px; 
                                {{ $backgroundColor2 }};{{ $backgroundColor4 }};{{ $backgroundColor5 }};{{ $backgroundColor6 }};{{ $backgroundColor7 }};"
                                            class="text-center">
                                            <strong>{{ $salesCount }}</strong>
                                        </td>
                                    @endforeach

                                    <td style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253); background-color: #cccbcb; border-radius: 15px;"
                                        class="text-center">
                                        <input type="text" wire:model.defer="objectif.{{ $user2->id }}"
                                            wire:keydown.enter.prevent="updateObjective({{ $user2->id }})"
                                            placeholder="{{ $user2->objectif }}"
                                            style="background-color: #cccbcb; border: none; font-size: 0.812rem; 
                                            font-weight: bolder; color:black; width:30px">
                                    </td>
                                    <td class="text-center"
                                        style="padding: 0.5rem; border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                        <strong>{{ $totalSalesCount }}</strong>
                                    </td>
                                    @foreach (fetchMonthDates() as $date)
                                        @php
                                            $carbonDate = Carbon\Carbon::parse($date);
                                            
                                            $salesCount =
                                                $sales2
                                                    ->where('user_id', $user2->id)
                                                    ->where('date_confirm', $carbonDate)
                                                    ->first()->sales_count ?? 0;
                                            
                                            $totalSalesCountMonth += $salesCount;
                                            $backgroundColor = $totalSalesCountMonth != 0 ? 'background-color: #5c6bc0; color: white ' : '';
                                        @endphp
                                    @endforeach
                                    <td class="text-center"
                                        style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px; {{ $backgroundColor }};">
                                        <strong>{{ $totalSalesCountMonth }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="font-size:15px; padding: 0.8rem">Total</th>
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
                                        style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor4 }};">
                                        <strong>{{ $salesCount }}</strong>
                                    </td>
                                @endforeach
                                <td class="text-center"
                                    style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;">
                                </td>
                                <td class="text-center"
                                    style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
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
                                    style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #c5cae9; border-radius:15px;{{ $backgroundColor3 }};">
                                    <strong>{{ $grandTotalMonth }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endauth

<script>
    window.addEventListener('showSuccessMessage', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast: 'success',
            title: event.detail.message || "Opération effectuée avec succès",
            showConfirmButton: false,
            timer: 5000
        })
    });
</script>  