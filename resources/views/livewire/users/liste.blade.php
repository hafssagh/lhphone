<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des utilisateurs</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div>
                <button class="btn btn-secondary btn-sm" type="button" wire:click.prevent="goToaddUser()">
                    <i class="mdi mdi-account-plus"></i>&nbsp;Nouvel utilisateur</button>
            </div>
        </div>
        <div class="table-responsive" style="height: 300px;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:5%"></th>
                        <th style="width:30%">Utilisateurs</th>
                        <th style="width:20%">Rôles</th>
                        <th class="text-center" style="width:15%">Ajouté</th>
                        <th class="text-center" style="width:30%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><img src="../assets/images/user.png"></td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->allRoleName }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($user->date_contract)->diffForHumans() }}</td>
                            <td class="text-center">
                                <a href="javascript:;" class="btn btn-sm btn-icon">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg>
                                    </span>
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-icon">
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
        </div>
    </div>
    <div class="card-footer">
        <div class="float-end">
            {{ $users->links() }}
        </div>
    </div>
</div>
