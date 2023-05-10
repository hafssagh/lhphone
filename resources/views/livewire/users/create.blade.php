<div class="card">
    <div class="card-body">
        <label class="text-end float-end" wire:click.prevent='goToListeUser()'>X</label><br>
        <h3 class="card-title">Formulaire de création d'un nouvel utilisateur</h3>

    
        <!-- form fields for step 3 -->
        <form role="form" wire:submit.prevent="addUser()">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="first_name">Nom</label>
                            <input type="text" wire:model="newUser.first_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="last_name">Prénom</label>
                            <input type="text" wire:model="newUser.last_name" class="form-control"
                            >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email">Adresse Email</label>
                            <input type="email" wire:model="newUser.email" class="form-control"
                            >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe</label>
                            <input type="password" wire:model="newUser.password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="id_card">Numéro piéce d'identité</label>
                            <input type="text" wire:model="newUser.id_card" class="form-control"
                            >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="text" wire:model="newUser.phone" class="form-control" >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="birthday">Date de naissance</label>
                            <input type="text" wire:model="newUser.birthday" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="date_contract">Date du contrat</label>
                            <input type="text" wire:model="newUser.date_contract" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Type du contrat</label>
                            <select class="form-control bg-white" wire:model="newUser.type_contract">
                                <option value="">---------</option>
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="temp">Travail temporaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="duration_contract">Durée du contrat</label>
                            <input type="text" wire:model="newUser.duration_contract" class="form-control"
                                id="duration_contract">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="duration_contract">Salaire brute</label>
                            <input type="text" wire:model="newUser.duration_contract" class="form-control"
                                id="duration_contract">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="d-flex flex-row-reverse">
                <button type="submit" class="btn btn-success justify-content-end">Enregistrer</button>
               
            </div>
        </form>
    </div>
</div>

