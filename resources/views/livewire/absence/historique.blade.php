<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des absence</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
        </div><br>
        <div class="table" style="height: 300px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Date d'absence</th>
                        <th>Heures d'absence</th>
                        <th>Justification</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absences as $absence)
                        <tr>
                            <td>{{ $absence->users->first_name }} {{ $absence->users->last_name }}</td>
                            <td>{{ $absence->date }}</td>
                            <td>{{ $absence->abs_hours }} Heures</td>
                            <td>{{ $absence->justification }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
    </div>
</div>


