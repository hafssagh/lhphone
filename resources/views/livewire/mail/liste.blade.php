<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <h4 class="card-title card-title-dash">Propositions d'aujourd'hui {{ $today }} 
                <br> 
                @can('agent')
                <div>
                    <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="goToaddPropos"
                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg>
                        &nbsp; Nouvelle proposition</button>
                </div>
            @endcan
            </h4>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <button type="button" class="btn btn-outline-dark" wire:click="goToPropWeek"
                    style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Semaine</button>
                <button type="button" class="btn btn-outline-dark" wire:click="goToPropMonth"
                    style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Mois</button>
                 </div>
            
            </div><br>
            <div class="calendar">
                <div class="lines">
                    @php
                        $startHour = 9;
                        $endHour = 18;
                        $intervalMinutes = 30;
                    @endphp
                    @for ($hour = $startHour; $hour <= $endHour; $hour++)
                        @for ($minute = 0; $minute < 60; $minute += $intervalMinutes)
                            <div class="line">
                                @php
                                    $formattedHour = sprintf("%02d:%02d", $hour, $minute);
                                @endphp
                                <span class="hour">{{ $formattedHour }}</span>
                                <div class="events">
                                    @foreach ($mails as $mail)
                                        @php
                                            $mailHour = intval($mail->created_at->format('H'));
                                            $mailMinute = intval($mail->created_at->format('i'));
                                            $eventColor = '';
                                            if ($mailHour == $hour && $mailMinute >= $minute && $mailMinute < ($minute + $intervalMinutes)) {
                                                if ($mail->state == '0') {
                                                    $eventColor = '#ececec';
                                                } elseif ($mail->state == '1') {
                                                    $eventColor = '#c8e6c9';
                                                } elseif ($mail->state == '-1') {
                                                    $eventColor = '#ffe2e0';
                                                } elseif ($mail->state == '3') {
                                                    $eventColor = '#faf38c';
                                                }
                                            }
                                        @endphp
                                        @if ($mailHour == $hour && $mailMinute >= $minute && $mailMinute < ($minute + $intervalMinutes))
                                            <div class="event" style="background-color: {{ $eventColor }};">
                                                <div class="event-details">
                                                    <button class="btn btn-sm text-black mb-0 me-0" data-toggle="modal"
                                                        data-target="#exampleModal{{ $mail->id }}">
                                                        <strong>{{ $mail->company }}</strong>
                                                        <br>
                                                        @cannot('agent')
                                                            {{ $mail->users->last_name }}{{ $mail->users->first_name }}
                                                        @endcannot
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endfor
                    @endfor
                </div>
            </div>
            
        </div>
    </div>

    @foreach ($mails as $mail)
        <div class="modal fade" id="exampleModal{{ $mail->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content" style='width:600px'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $mail->company }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="display: flex; justify-content: center; align-items: center; ">
                        <div>
                            <strong class="title">Responsable:</strong> <span
                                class="text">{{ $mail->nameClient }}</span>
                            <br>
                            <strong class="title">No de téléphone:</strong> <span
                                class="text">{{ $mail->numClient }}</span> <br>
                            <strong class="title">Adresse Email:</strong> <span
                                class="text">{{ $mail->emailClient }}</span> <br>
                            <strong class="title">Adresse:</strong> <span class="text">{{ $mail->adresse }}</span>
                            <br>
                            @if ($mail->remark != null)
                                <strong class="title">Remarque:</strong> <span
                                    class="text">{{ $mail->remark }}</span>
                                <br>
                            @endif
                        </div>
                    </div>
                    @cannot('agent')
                        @if ($mail->state == '0')
                            <div class="modal-footer">
                                <div class="square">
                                    <button class="btn btn-sm" wire:click="mailValide({{ $mail->id }}, '3')">
                                        <strong>Rappeler</strong> 
                                    </button>
                                </div>
                                <span class="svg-icon svg-icon-md" wire:click="mailValide({{ $mail->id }}, '1')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                        <path
                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z" />
                                    </svg>
                                </span> &nbsp;
                                <span class="svg-icon svg-icon-md" wire:click="mailValide({{ $mail->id }}, '-1')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>
                            </div>
                        @endif
                    @endcannot
                </div>
            </div>
        </div>
    @endforeach