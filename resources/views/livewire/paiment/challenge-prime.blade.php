<div class="row"> 
    <div class="d-flex justify-content-between">
        <div class="text-start">
            <div class="input-group">
                <input type="text" class="form-control" wire:model.debounce.250ms="search" placeholder="Rechercher ...">
                <span class="input-group-text"><i class="icon-search"></i></span>
            </div>
        </div>
    </div>
    <br><br>
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
                                    <td style=" padding: 0.7rem;"> {{ $challenges->last_name }}
                                        {{ $challenges->first_name }}</td>
                                    <td style=" padding: 0.7rem;" class="text-center">
                                        <div class="badge badge-opacity-primary" style="border-radius: 0;">
                                            {{ $challenges->challenge }} DH</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-end">
                        {{ $challenge->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 grid-margin">
        <div class="card card-rounded">
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
                                    <td style=" padding: 0.7rem;"> {{ $primes->last_name }} {{ $primes->first_name }}
                                    </td>
                                    <td class="text-center" style=" padding: 0.7rem;">
                                        <div class="badge badge-opacity-primary" style="border-radius: 0;">
                                            {{ $primes->prime }} DH</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-end">
                        {{ $prime->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
