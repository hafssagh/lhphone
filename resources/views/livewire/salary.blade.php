

<div class="row">
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
    <div class="col-6 grid-margin">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title card-title-dash">Listes des challenges</h4>
                    </div>
                </div>
                <div class="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th class="text-center">Challenge</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($challenge as $challenges)
                                <tr>
                                    <td> {{ $challenges->last_name }} {{ $challenges->first_name }}</td>
                                    <td class="text-center">{{ $challenges->challenge }} DH</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-rounded mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title card-title-dash">Liste des primes</h4>
                    </div>
                </div>
                <div class="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th class="text-center">Prime</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prime as $primes)
                                <tr>
                                    <td> {{ $primes->last_name }} {{ $primes->first_name }}</td>
                                    <td class="text-center">{{ $primes->prime }} DH</td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 grid-margin ">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash">Liste des salaires</h4><br>
                    </div>
                </div>   
                     
                <div class="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th class="text-center">Salaire de base</th>
                                <th class="text-center">Salaire par jour</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salary as $salaries)
                                <tr>
                                    <td> {{ $salaries->last_name }} {{ $salaries->first_name }}</td>
                                    <td class="text-center">{{ $salaries->base_salary }} DH</td>
                                    <td class="text-center">{{ $salaries->salary }} DH</td>
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
</div>

