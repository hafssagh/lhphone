{{-- <div>
    <input class="form-control type="file" name="photo" wire:model="addphoto"/>
    <button wire:click="updateProfilePhoto">Save changes</button>
    @if ($addphoto)
    <img src="{{ $addphoto->temporaryUrl() }}">
    @endif

@if (auth()->user()->photo != '')
   <img src="{{asset('storage/' . auth()->user()->photo)}}" alt="">
@else
non
@endif
</div> --}}
<div class="row">
    <div class="col-md-7 grid-margin grid-margin-md-0 stretch-card">
        <div class="card">
            <div class="card-body text-center"><br>
                <h4>{{ userName() }}</h4>
                @if (auth()->user()->comapany == 'h2f')
                    <p class="text-muted mb-0">H2F PREMIUM</p>
                @else
                    <p class="text-muted mb-0">LH PHONE</p>
                @endif

                <br>
                <table class="table table-borderless ">
                    <thead>
                        <tr>
                            <th style="width:40%; text-align: center; padding: 0.5rem; font-weight: lighter;">
                                Type contrat</th>
                            <th style="width:60%; text-align: center; padding: 0.5rem; ">
                                <strong>{{ auth()->user()->type_contract }}</strong>
                            </th>
                        </tr>
                        <tr>
                            <th style="width:40%; text-align: center; padding: 0.5rem; font-weight: lighter;">
                                Date contrat</th>
                            <th style="width:60%; text-align: center; padding: 0.5rem; ">
                                <strong>{{ auth()->user()->date_contract }}</strong>
                            </th>
                        </tr>
                        <tr>
                            <th style="width:40%; text-align: center; padding: 0.5rem; font-weight: lighter;">
                                Salaire Brute</th>
                            <th style="width:60%; text-align: center; padding: 0.5rem; ">
                                <strong>{{ auth()->user()->base_salary }} DH</strong>
                            </th>
                        </tr>
                    </thead>
                </table>
                <br>
                <div class="border-top pt-3">
                    <div class="row">
                        <div class="col-4">
                            <h6>{{auth()->user()->salary}} DH</h6>
                            <p>Salaire</p>
                        </div>
                        <div class="col-4">
                            <h6>{{auth()->user()->work_hours}}</h6>
                            <p>Heures travaillées</p>
                        </div>
                        <div class="col-4">
                            <h6>--</h6>
                            <p>Objectif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 grid-margin grid-margin-md-0 stretch-card">
        <div class="card">
            <div class="card-body text-center"><br>
                {{--  <h4 class="card-title d-flex">Changer la photo du profile</h4> --}}
                <div>
                    @if (auth()->user()->photo != '' || auth()->user()->photo != null)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="img-lg rounded-circle mb-2">
                    @else
                        <td> <img src="../assets/images/user.png" class="img-lg rounded-circle mb-2"></td>
                    @endif
                </div>
                <br><br>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-center mt-3">
                        <input class="form-control" type="file" name="photo" wire:model="addphoto">
                    </div>
                </div><br>
                <div class=" justify-content-center">
                    <button wire:click="updateProfilePhoto" type="submit" class="btn text-black"
                        style="font-size: 14px;  padding: 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path
                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                        </svg>
                        Enregistrer</button>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.addEventListener('showSuccessMessage', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast: 'success',
            title: event.detail.message || "Opération effectuée avec succès",
            showConfirmButton: false,
            timer: 5000
        })
    });
</script>