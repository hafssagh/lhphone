{{-- <div class="row"> 
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
                                <th class="text-center">Agent</th>
                                <th class="text-center">Challenge</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($challenge as $challenges)
                                <tr>
                                    <td class="text-center" style=" padding: 0.5rem;"> {{ $challenges->last_name }}
                                        {{ $challenges->first_name }}</td>
                                    <td style=" padding: 0.5rem;" class="text-center">
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
                                <th class="text-center">Agent</th>
                                <th class="text-center">Prime</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prime as $primes)
                                <tr>
                                    <td class="text-center" style=" padding: 0.5rem;"> {{ $primes->last_name }} {{ $primes->first_name }}
                                    </td>
                                    <td class="text-center" style=" padding: 0.5rem;">
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
 --}}

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="text-start">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.debounce.250ms="search"
                                placeholder="Rechercher ...">
                            <span class="input-group-text"><i class="icon-search"></i></span>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="card-title">Challenges</h6>
                        <div>
                            @foreach ($challenge as $challenges)
                                <div class="card rounded border mb-2"
                                    style="height: 55px; display: flex; justify-content: center; ">
                                    <div class="card-body p-3">
                                        <div class="media d-flex align-items-center justify-content-between">
                                            <div class="d-flex">
                                                @if ($challenges->photo != '' || $challenges->photo != null)
                                                    <img class="rounded"
                                                        src="{{ asset('storage/' . $challenges->photo) }}"
                                                        style="height: 35px; width: 35px;">
                                                @else
                                                    <img class="rounded" src="../assets/images/user2.png"
                                                        style="height: 35px; width: 35px; ">
                                                @endif
                                                <div style="margin-left:20px">
                                                    <span class="fw-bold"
                                                        style="font-size:15px; margin-bottom: 0;">{{ $challenges->last_name }}
                                                        {{ $challenges->first_name }}</span><br>
                                                    <small class="text-muted" style="font-size:12px ;margin-bottom: 0;">
                                                        @if ($challenges->company == 'lh')
                                                            LH Phone
                                                        @else
                                                            H2F Premium
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            <div style="margin-right:30px">
                                                <h5 class="fw-bold" style="color:#303f9f">{{ $challenges->challenge }}
                                                    DH</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="card-title">Primes : <span style="font-size: 15px; color:darkgrey"
                                id="moisAnnee"></span></h6>
                        <div class="">
                            @foreach ($prime as $primes)
                                <div class="card rounded border mb-2"
                                    style="height: 55px; display: flex; justify-content: center; ">
                                    <div class="card-body p-3">
                                        <div class="media d-flex align-items-center justify-content-between">
                                            <div class="d-flex">
                                                @if ($primes->photo != '' || $primes->photo != null)
                                                    <img class="rounded" src="{{ asset('storage/' . $primes->photo) }}"
                                                        style="height: 35px; width: 35px;">
                                                @else
                                                    <img class="rounded" src="../assets/images/user2.png"
                                                        style="height: 35px; width: 35px; ">
                                                @endif
                                                <div style="margin-left:20px">
                                                    <span class="fw-bold"
                                                        style="font-size:15px ;margin-bottom: 0;">{{ $primes->last_name }}
                                                        {{ $primes->first_name }}</span><br>
                                                    <small class="text-muted" style="font-size:12px ;margin-bottom: 0;">
                                                        @if ($primes->company == 'lh')
                                                            LH Phone
                                                        @else
                                                            H2F Premium
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            <div style="margin-right:30px">
                                                <h5 class="fw-bold" style="color:#303f9f">{{ $primes->prime }} DH</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var date = new Date();
        var mois = date.toLocaleString("default", {
            month: "long"
        });
        var annee = date.getFullYear();
        var moisAnnee = mois + " " + annee;

        document.getElementById("moisAnnee").textContent = moisAnnee;
    });
</script>
