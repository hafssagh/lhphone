<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des utilisateurs</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click.prevent="goToaddUser()"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Nouvel utilisateur</button>
            </div>
        </div>
        <div class="table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:5%"></th>
                        <th>Utilisateurs</th>
                        @canAny(['admin', 'superadmin'])
                            <th>Rôles</th>
                            <th class="text-center">Société</th>
                        @endcanAny
                        @can('manager')
                            <th>Email</th>
                            <th class="text-center">Groupe</th>
                            <th class="text-center">Salaire</th>
                        @endcan
                        <th class="text-center">Ajouté</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            @if ($user->photo != '' || $user->photo != null)
                                <td style="padding: 0.8rem;"> <img class="img rounded-circle "
                                        src="{{ asset('storage/' . $user->photo) }}" style="height: 36px; width:36px">
                                </td>
                            @else
                                <td style="padding: 0.8rem;"> <img src="../assets/images/user.png"></td>
                            @endif
                            @if (count($user->resignations) > 0)
                                <td style="padding: 0.8rem;"><del> {{ $user->last_name }} {{ $user->first_name }}</del>
                                    <p class="text-danger">A quitté</p>
                                </td> <br>
                            @else
                                <td style="padding: 0.8rem;"> {{ $user->last_name }} {{ $user->first_name }}
                            @endif
                            @canAny(['admin', 'superadmin'])
                                <td style="padding: 0.8rem;">{{ $user->allRoleName }}</td>
                                <td class="text-center" style="padding: 0.8rem;">
                                    @if ($user->company == 'h2f')
                                        <div class="badge badge-opacity-primary">H2F PREMIUM</div>
                                    @else
                                        <div class="badge badge-opacity-danger" style="background-color: #fedfdd;">LH PHONE
                                        </div>
                                    @endif
                                </td>
                            @endcanAny
                            @can('manager')
                                <td style="padding: 0.8rem;">{{ $user->email }}</td>
                                <td class="text-center" style="padding: 0.8rem;">
                                    @if ($user->group == '1')
                                        <div class="badge badge-opacity-primary">Equipe Chris Ezzahra</div>
                                    @else
                                        <div class="badge badge-opacity-danger" style="background-color: #fedfdd;">
                                            Equipe Amine
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center" style="padding: 0.8rem;">{{ $user->base_salary }}</td>
                            @endcan
                            <td class="text-center" style="padding: 0.8rem;">
                                {{ \Carbon\Carbon::parse($user->date_contract)->diffForHumans() }}</td>
                            <td class="text-center" style="padding: 0.8rem;">
                                @canAny(['admin', 'superadmin'])
                                    <a href="javascript:;" class="btn btn-sm btn-icon"
                                        wire:click="goToRoleUser({{ $user->id }})">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-toggles" viewBox="0 0 16 16">
                                                <path
                                                    d="M4.5 9a3.5 3.5 0 1 0 0 7h7a3.5 3.5 0 1 0 0-7h-7zm7 6a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm-7-14a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm2.45 0A3.49 3.49 0 0 1 8 3.5 3.49 3.49 0 0 1 6.95 6h4.55a2.5 2.5 0 0 0 0-5H6.95zM4.5 0h7a3.5 3.5 0 1 1 0 7h-7a3.5 3.5 0 1 1 0-7z" />
                                            </svg>
                                        </span>
                                    </a>
                                @endcanAny
                                <a href="javascript:;" class="btn btn-sm btn-icon"
                                    wire:click="goToEditUser({{ $user->id }})">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.36 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg>
                                    </span>
                                </a>
                                <a href="javascript:;"
                                    wire:click="confirmDelete('{{ $user->first_name }} {{ $user->last_name }}' , {{ $user->id }})"
                                    class="btn btn-sm btn-icon">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                        </svg>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
