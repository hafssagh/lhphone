
     @if (Auth::user()->last_name === 'ELMOURABIT' || Auth::user()->last_name === 'By' || Auth::user()->last_name === 'EL MESSIOUI')
         <div class="row">
             <div class="col-md-12">
                 <div class="card">
                     <div class="card-body d-flex justify-content-center">
                         <div class="table-container">
                             <table class="table table-borderless ">
                                 <thead>
                                     <tr>
                                         <th style="width: 10px; ">Groupe 1</th>
                                         @foreach ($weekDates as $date)
                                             <th style="font-size: 13px;" class="text-center">
                                                 {{ \Carbon\Carbon::parse($date)->format('d-m') }} </th>
                                         @endforeach
                                         <th class="text-center">Total\S</th>
                                         <th class="text-center">Total\M</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($users as $user)
                                         <tr>
                                             <td style="padding: 0.7rem; min-width: 50px; max-width: 147px;"
                                                 class="text-truncate">
                                                 <strong>{{ $user->first_name }} </strong>
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
                                                     $backgroundColor = $salesCount != 0 ? 'background-color: #5cb85c ;' : '';
                                                     
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
                                                     
                                                     $suspension = $suspension1
                                                         ->where('user_id', $user->id)
                                                         ->where('date_debut', '<=', $date)
                                                         ->where('date_fin', '>=', $date)
                                                         ->first();
                                                     
                                                     $backgroundColor8 = $suspension ? 'background-color: #d32f2f ; color: #d32f2f' : '';
                                                     
                                                     $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                                     $backgroundColor5 = $absenceUser12 ? 'background-color: #9EEFF0 ' : '';
                                                     $backgroundColor6 = $absenceUserDemi ? 'background-color: #FED071 ' : '';
                                                     $backgroundColor7 = $retard ? 'background-color: #A6B9FF ' : '';
                                                     
                                                     $resignationUser = $resignation->where('user_id', $user->id)->first();
                                                     $backgroundColor4 = $resignationUser ? 'background-color: #5A5A5A ; color: #5A5A5A' : '';
                                                     
                                                     $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                                 @endphp
                                                 <td style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color:#ececec ; {{ $backgroundColor }}; border-radius:15px; 
                                {{ $backgroundColor2 }}; {{ $backgroundColor4 }}; {{ $backgroundColor5 }}; {{ $backgroundColor6 }}; {{ $backgroundColor7 }}; {{ $backgroundColor8 }}"
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
                                     <tr>
                                         <th style="font-size:15px; padding: 0.8rem">Reste</th>
                                         @foreach ($weekDates as $date)
                                             <td style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253); background-color: #cccbcb; border-radius: 15px;"
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
                                                     <input class="text-center" type="text" wire:model.defer="objective"
                                                         wire:keydown.enter.prevent="updateA"
                                                         placeholder="{{ $reste }}"
                                                         style="background-color: #cccbcb; border: none; font-size: 0.812rem; 
                                    font-weight: bolder; color:black; width:30px">
                                                 @endforeach
                                             </td>
                                         @endforeach
                                         <td class="text-center"
                                             style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
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
                                             style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
                                         </td>
                                     </tr>
                                 </tfoot>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div><br>
     @endif

     @if (Auth::user()->last_name === 'Essaid' || Auth::user()->last_name === 'EL MESSIOUI')
         <div class="row">
             <div class="col-md-12">
                 <div class="card">
                     <div class="card-body d-flex justify-content-center">
                         <div class="table-container">
                             <table class="table table-borderless">
                                 <thead>
                                     <tr>
                                         <th>Groupe 2</th>
                                         @foreach ($weekDates as $date)
                                             <th style="font-size:13px" class="text-center">
                                                 {{ \Carbon\Carbon::parse($date)->format('d-m') }}</th>
                                         @endforeach
                                         <th class="text-center"> Objectif</th>
                                         <th class="text-center">Total\S</th>
                                         <th class="text-center">Total\M</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($users2 as $user2)
                                         <tr>
                                             <td style="padding: 0.5rem; min-width: 50px; max-width: 147px;"
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
                                                     $backgroundColor = $salesCount != 0 ? 'background-color: #5cb85c' : '';
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
                                                     
                                                     $suspension = $suspension2
                                                         ->where('user_id', $user2->id)
                                                         ->where('date_debut', '<=', $date)
                                                         ->where('date_fin', '>=', $date)
                                                         ->first();
                                                     
                                                     $backgroundColor8 = $suspension ? 'background-color: #d32f2f ; color: #d32f2f' : '';
                                                     
                                                     $backgroundColor2 = $absenceUser ? 'background-color: #FFFF66 ' : '';
                                                     $backgroundColor5 = $absenceUser12 ? 'background-color: #9EEFF0 ' : '';
                                                     $backgroundColor6 = $absenceUserDemi ? 'background-color: #FED071 ' : '';
                                                     $backgroundColor7 = $retard ? 'background-color: #6f84ab ' : '';
                                                     
                                                     $resignationUser = $resignation2->where('user_id', $user2->id)->first();
                                                     $backgroundColor4 = $resignationUser ? 'background-color: #5A5A5A ; color: #5A5A5A ' : '';
                                                     
                                                     $backgroundColor3 = $totalSalesCount ? 'background-color: #5c6bc0; color:white' : '';
                                                 @endphp
                                                 <td style="padding: 0.5rem ;padding: 0.5rem ;border: 4px solid rgb(253, 253, 253);background-color: #ececec; {{ $backgroundColor }}; border-radius:15px; 
                                {{ $backgroundColor2 }};{{ $backgroundColor4 }};{{ $backgroundColor5 }};{{ $backgroundColor6 }};{{ $backgroundColor7 }}; {{ $backgroundColor8 }}"
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
                                     <tr>
                                         <th style="font-size:15px; padding: 0.8rem">Reste</th>
                                         @foreach ($weekDates as $date)
                                             <td style="padding: 0.5rem ;border: 4px solid rgb(253, 253, 253); background-color: #cccbcb; border-radius: 15px;"
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
                                                     <input class="text-center" type="text" wire:model.defer="objective"
                                                         wire:keydown.enter.prevent="updateB"
                                                         placeholder="{{ $reste }}"
                                                         style="background-color: #cccbcb; border: none; font-size: 0.812rem; 
                                    font-weight: bolder; color:black; width:30px">
                                                 @endforeach
                                             </td>
                                         @endforeach
                                         <td class="text-center"
                                             style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
                                         </td>
                                         <td class="text-center"
                                             style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253); background-color: #cccbcb; border-radius: 15px;">
                                             @foreach ($weekDates as $date)
                                                 @php
                                                     $dayOfWeek = Carbon\Carbon::parse($date)->dayOfWeek;
                                                     if ($dayOfWeek === Carbon\Carbon::SATURDAY || $dayOfWeek === Carbon\Carbon::SUNDAY) {
                                                         $reste = 0;
                                                     } else {
                                                         $salesCount = $sales2->where('date_confirm', $date)->sum('sales_count');
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
                                             style="padding: 0.7rem; border: 4px solid rgb(253, 253, 253);background-color: #cccbcb; border-radius:15px;">
                                         </td>
                                     </tr>
                                 </tfoot>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     @endif

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
