<div class="row">
    <div class="card card-rounded">
        <div class="card-body">
            <div class="d-sm-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title card-title-dash">Liste des salaires</h4><br>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="text-start">
                    <div class="input-group">
                        <input type="text" class="form-control" wire:model.debounce.250ms='search'
                            placeholder="Rechercher ...">
                        <span class="input-group-text"><i class="icon-search"></i></span>
                    </div>
                </div>
                <form wire:submit.prevent="render" class="text-end">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="lh"
                            wire:model="selectedSocieties">
                        <label class="form-check-label" for="flexSwitchCheckDefault">H2F Premium</label>
                    </div>
                    <div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="h2f"
                                wire:model="selectedSocieties">
                            <label class="form-check-label" for="flexSwitchCheckDefault">LH Phone</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:20%">&emsp;&emsp;Agent</th>
                            <th  style="width:40%" class="text-center">Salaire de base</th>
                            <th style="width:40%" class="text-center">Salaire par jour</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salary as $salaries)
                            <tr>
                                <td style="width:20% ; padding: 0.7rem; "> &emsp;&emsp;{{ $salaries->last_name }} {{ $salaries->first_name }}</td>
                                <td style="width:40% ; padding: 0.7rem;" class="text-center">{{ $salaries->base_salary }} DH</td>
                                <td style="width:40% ; padding: 0.7rem;" class="text-center">
                                    <div class="badge badge-opacity-primary" style="border-radius: 0;" >{{ $salaries->salary }} DH</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-end">
                    {{ $salary->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
