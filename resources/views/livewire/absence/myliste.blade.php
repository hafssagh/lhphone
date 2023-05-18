<div class="card card-rounded">
    <div class="card-body">
        <div class="table" style="height: 300px;">
            <table class="table ">
                <thead>
                    <tr>
                        <th>Date d'absence</th>
                        <th>Heures d'absence</th>
                        <th>Justification</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absencesAuth as $absenceAuth)
                        <tr>
                            <td>{{ $absenceAuth->date }}</td>
                            <td>{{ $absenceAuth->abs_hours }} Heures</td>
                            <td>{{ $absenceAuth->justification }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-auto">
                    <table class="table table-borderless ">
                        <thead>
                            <tr>
                                <th style="padding: 0.5rem;">Heures d'absence </th>
                                <th style="font-weight: lighter;  padding: 0.5rem; "></th>
                            </tr>
                            <tr>
                                <th style="padding: 0.5rem;">Heures de travail </th>
                                <th style="font-weight: lighter;  padding: 0.5rem; ">{{auth()->user()->work_hours}}
                                    <strong>  &emsp; / {{calculerHeuresTravailParMois()}}</strong></th>
                            </tr>
                            <tr>
                                <th style="padding: 0.1rem;"></th>
                                <th style="padding: 0.1rem; "></th>
                                <th style="padding: 0.1rem; "></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

