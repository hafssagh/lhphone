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
            <div class="btn-group" aria-label="Button group with nested dropdown">
                <a href="/proposal/all" class="btn btn-outline-dark"
                    style="font-size: 13px; height: 20px; text-align: center; line-height: 5px;">Tous</a>
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
                                $formattedHour = sprintf('%02d:%02d', $hour, $minute);
                            @endphp
                            <span class="hour">{{ $formattedHour }}</span>
                            <div class="events">
                                @foreach ($mails as $mail)
                                    @php
                                        $mailHour = null;
                                        $mailMinute = null;
                                        $eventColor = '';
                                        
                                        if ($mail && $mail->created_at) {
                                            $mailHour = intval($mail->created_at->format('H'));
                                            $mailMinute = intval($mail->created_at->format('i'));
                                        
                                            if ($mailHour == $hour && $mailMinute >= $minute && $mailMinute < $minute + $intervalMinutes) {
                                                if ($mail->state == '0') {
                                                    $eventColor = '#DCDCDC';
                                                } elseif ($mail->state == '1') {
                                                    $eventColor = '#b0d9b1';
                                                } elseif ($mail->state == '-1') {
                                                    $eventColor = '#f5c7c4';
                                                } elseif ($mail->state == '3') {
                                                    $eventColor = '#faf38c';
                                                }
                                            }
                                        }
                                    @endphp
                                    @if ($mail && $mailHour == $hour && $mailMinute >= $minute && $mailMinute < $minute + $intervalMinutes)
                                        <div class="event" style="background-color: {{ $eventColor }};">
                                            <div class="event-details">
                                                <button class="btn btn-sm text-black mb-0 me-0"
                                                    wire:click="goToEditMail({{ $mail->id }})">
                                                    @cannot('agent')
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                @cannot('agent')
                                                                    @if ($mail->send == 'rive')
                                                                        <span
                                                                            class=" vertical-text text-primary"><strong> Eco<br> Rive</strong>
                                                                        </span>
                                                                    @elseif ($mail->send == 's2ee')
                                                                        <span
                                                                            class=" vertical-text text-success"><strong>s2ee</strong>
                                                                        </span>
                                                                    @endif
                                                                @endcannot

                                                            </div>
                                                            <div class="col" style="margin-left:-10px;">
                                                                <strong>{{ $mail->company }} </strong>
                                                                @if ($mail->rappel != null)
                                                                    <span class="text-danger"> ({{ $mail->rappel }})</span>
                                                                @endif
                                                                <br>
                                                                {{ $mail->users->last_name }} {{ $mail->users->first_name }}
                                                            </div>
                                                        </div>
                                                    @endcannot
                                                    @can('agent')
                                                        <strong>{{ $mail->company }} </strong>
                                                        @if ($mail->rappel != null)
                                                            <span class="text-danger"> ({{ $mail->rappel }})</span>
                                                        @endif
                                                        <br>
                                                        @if ($mail->send == 'rive')
                                                            <span class="text-primary"><strong>RiveEco</strong>
                                                            </span>
                                                        @elseif ($mail->send == 's2ee')
                                                            <span class="text-success"><strong>s2ee</strong>
                                                            </span>
                                                        @endif
                                                    @endcan
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
