<div class="row">
    <div class="col-lg-5 grid-margin stretch-card">
        <!--form mask starts-->
        <div class="card">
            <div class="card-body"><br>
                <div class="text-center pb-4">
                    @if ($roleUser['photo'] != '' || $roleUser['photo'] != null)
                        <img class="img rounded-circle " src="{{ asset('storage/' . $roleUser['photo']) }}"
                                style="height: 92px; width:92px">
                    @else
                        <img class="img-lg rounded-circle" src="/assets/images/user.png">
                    @endif
                    <br>
                    <br>
                    <div class="mb-3">
                        <h3> {{ $roleUser['last_name'] }} {{ $roleUser['first_name'] }}</h3>
                        <div class="d-flex align-items-center justify-content-center">
                            @if ($roleUser['company'] == 'h2f')
                                <h5 class="mb-0 me-2 text-danger">H2F PREMIUM</h5>
                            @else
                                <h5 class="mb-0 me-2 text-danger"> LH PHONE</h5>
                            @endif
                        </div>
                    </div><br>
                    <table class="table table-borderless ">
                        <thead>
                            <tr>
                                <th style="width:40%; text-align: left; padding: 0.5rem; font-weight: lighter;">
                                    Téléphone</th>
                                <th style="width:60; text-align: left; padding: 0.5rem; font-weight: lighter;">Adresse
                                    Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:40%; text-align: left; padding: 0.5rem;">
                                    <strong>{{ $roleUser['phone'] }}</srtong>
                                </td>
                                <td style="width:60; text-align: left; padding: 0.5rem;">
                                    <strong>{{ $roleUser['email'] }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--form mask ends-->
    </div>
    <div class="col-lg-7 grid-margin stretch-card">
        <!--x-editable starts-->
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <h4 class="card-title">Rôles</h4>
                    <label class="text-end float-end" wire:click.prevent='goToListeUser()'>X</label>
                </div><br>
                @foreach ($rolePermissions['roles'] as $role)
                    <div style="margin-left: 20px; margin-right: 20px;">
                        <div class="list align-items-center border-bottom py-1">
                            <div class="wrapper w-100">
                                <div class=" d-flex justify-content-between">
                                    <h6 class="" style="margin-top: 13px;">
                                        <a data-parent="#accordion" href="#" aria-expanded="true"
                                            style="color:black ;text-decoration: none;">
                                            {{ $role['role_name'] }}
                                        </a>
                                    </h6>
                                    <div class="form-check form-switch float-end">
                                        <input class="form-check-input " type="checkbox" role="switch"
                                            wire:model.lazy="rolePermissions.roles.{{ $loop->index }}.active"
                                            id="flexSwitchCheckDefault{{ $role['role_id'] }}"
                                            @if ($role['active']) checked @endif>
                                        <label class="form-check-label"
                                            for="flexSwitchCheckDefault{{ $role['role_id'] }}">
                                            {{ $role['active'] ? 'Activé' : 'Désactivé' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- @json($rolePermissions["roles"]) --}}
                <br>
                <div class="d-flex flex-row-reverse">
                    <button class="btn btn-lg text-dark mb-0 me-0" wire:click="updateRole"
                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path
                                d="M12.792 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
        <!--x-editable ends-->
    </div>

</div>
