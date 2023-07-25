<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des absences</h4><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <form wire:submit.prevent="render">
                    <select class="form-select" wire:model="selectedMonth" id="selectedMonth" style="font-size: 13px">
                        <option value="all">Tous les mois</option>
                        <option value="1">Janvier</option>
                        <option value="2">Février</option>
                        <option value="3">Mars</option>
                        <option value="4">Avril</option>
                        <option value="5">Mai</option>
                        <option value="6">Juin</option>
                        <option value="7">Juillet</option>
                        <option value="8">Août</option>
                        <option value="9">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select>
                </form>
            </div>
        </div>

        <br>
        @if ($selectedAbsenceIds)
            <div style="display: flex; align-items: center;">
                <p style="margin-right: 10px;">Absences sélectionnées : {{ count($selectedAbsenceIds) }}</p>
                <button wire:click="confirmDelete" wire:loading.attr="disabled" type="submit" class="btn text-danger"
                    style="margin-bottom:10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-trash" viewBox="0 0 16 16">
                        <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                        <path
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                    </svg>
                    Supprimer
                </button>
            </div>
        @endif

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Agent</th>
                        <th class="text-center">Date d'absence</th>
                        <th class="text-center">Heures d'absence</th>
                        <th>Justification</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absences as $absence)
                        <tr>
                            @can('superadmin')
                            <td style="padding: 0.7rem;">
                                <input type="checkbox" wire:model="selectedAbsenceIds" value="{{ $absence->id }}">
                            </td>  
                            @endcan
                            @cannot('superadmin')
                            <td style="padding: 0.7rem;"> </td>  
                            @endcannot
                            <td style="padding: 0.7rem;">{{ $absence->users->first_name }} {{ $absence->users->last_name }}</td>
                            <td style="padding: 0.7rem;" class="text-center">{{ \Carbon\Carbon::parse($absence->date)->format('d-m-Y') }}
                            </td>
                            <td style="padding: 0.7rem;" class="text-center">{{ $absence->abs_hours }} Heures</td>
                            <td style="padding: 0.7rem;">{{ $absence->justification }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $absences->links() }}
            </div>
        </div>
    </div>

</div>


<script>
    window.addEventListener('showConfirmMessage', event => {
        Swal.fire({
            text: event.detail.message.text,
            icon: event.detail.message.type,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Continuer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.deleteSelected()
            }
        })
        window.addEventListener('showSuccessMessage', event => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                toast: 'success',
                title: event.detail.message || "Opération effectuée avec succès",
                showConfirmButton: false,
                timer: 3000
            })
        });
    });
</script>
