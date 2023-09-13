<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Liste des avancements de salaire</h4><br>
                <div class="input-group">
                    <input type="text" class="form-control" wire:model.debounce.250ms='search'
                        placeholder="Rechercher ...">
                    <span class="input-group-text"><i class="icon-search"></i></span>
                </div>
            </div>
            <div>
                <button class="btn btn-lg text-black mb-0 me-0" type="button" wire:click="toggleShowAddForm"
                    style="font-size: 14px; line-height: 18px; padding: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    &nbsp;Ajouter </button>
            </div>
        </div><br>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Agent</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">Cause</th>
                        <th class="text-center">Ajouté</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($isAddAdvance)
                        <tr>
                            <form action="">
                                <td class="text-center" style="padding: 0.8rem;">
                                    <select wire:model="newAdvance.user"
                                        class="form-control bg-white text-black @error('newAdvance.user') is-invalid @enderror">
                                        <option value=""></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->last_name }} {{ $user->first_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 0.8rem;"> <input
                                        class="form-control @error('newAdvance.advance') is-invalid @enderror"
                                        type="text" wire:model="newAdvance.advance"
                                        wire:keydown.enter='addNewAdvance'>
                                </td>
                                <td style="padding: 0.8rem;"> <input
                                        class="form-control @error('newAdvance.motif') is-invalid @enderror"
                                        type="text" wire:model="newAdvance.motif" wire:keydown.enter='addNewAdvance'>
                                </td>
                                <td style="padding: 0.8rem;"></td>
                                <td class="text-center" style="padding: 0.8rem;">
                                    <button wire:click.prevent='addNewAdvance'
                                        class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                        </svg>
                                        &nbsp; Valider</button>
                                    <button wire:click="toggleShowAddForm"
                                        class="btn btn-lg text-black mb-0 me-0 justify-content-end"
                                        style="font-size: 14px; line-height: 18px; padding: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                            <path
                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                        </svg>
                                        Annuler</button>
                                </td>
                            </form>
                        </tr>
                    @endif
                    @foreach ($avances as $avance)
                        <tr>
                            <td style="padding: 0.8rem;" class="text-center"> {{ $avance->users->last_name }}
                                {{ $avance->users->first_name }}</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $avance->advance }} DH</td>
                            <td class="text-center" style="padding: 0.8rem;">{{ $avance->motif }}</td>
                            <td class="text-center" style="padding: 0.8rem;">
                                {{ $avance->users->created_at->format('d-m-Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $avances->links() }}
            </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>



<style type="text/css">
    #outlook a {
        padding: 0;
    }

    body {
        margin: 0;
        padding: 0;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
    }

    table,
    td {
        border-collapse: collapse;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
    }

    img {
        border: 0;
        height: auto;
        line-height: 100%;
        outline: none;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
    }

    p {
        display: block;
        margin: 13px 0;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&amp;display=swap" rel="stylesheet"
    type="text/css" />
<style type="text/css">
    @import url(https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&amp;display=swap);
</style>
<style type="text/css">
    @media only screen and (min-width:480px) {
        .mj-column-per-100 {
            width: 100% !important;
            max-width: 100%;
        }
    }
</style>
<style type="text/css">
    @media only screen and (max-width:480px) {
        table.mj-full-width-mobile {
            width: 100% !important;
        }

        td.mj-full-width-mobile {
            width: auto !important;
        }
    }
</style>
<style type="text/css">
    a,
    span,
    td,
    th {
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
    }
</style>

<div style="background-color:#F4F5FB;">
    <div style="background-color:#F4F5FB;">
        <div style="margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="font-size:0px;word-break:break-word;">
                                                <div style="height:5px;">   </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div
            style="background:#ffffff url(https://www.transparenttextures.com/patterns/brushed-alum.png) top center / auto repeat;margin:0px auto;border-radius:20px;max-width:600px;">
            <div style="line-height:0;font-size:0; ">
                <table align="center" background="https://www.transparenttextures.com/patterns/brushed-alum.png"
                    border="0" cellpadding="0" cellspacing="0" role="presentation"
                    style="background:#ffffff url(https://www.transparenttextures.com/patterns/brushed-alum.png) top center / auto repeat;width:100%;border-radius:20px;">
                    <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                    style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                        style="vertical-align: top;" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center"
                                                    style="font-size: 0px; padding: 10px 25px; word-break: break-word;">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation"
                                                        style="border-collapse: collapse; border-spacing: 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center">
                                                                    <img height="auto" src="/assets/images/logo.png"
                                                                        style="border: 0; display: block; outline: none; text-decoration: none; height: auto; width: 60%; font-size: 13px;"
                                                                        width="" />
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="background:#F4F5FB;background-color:#F4F5FB;margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#F4F5FB;background-color:#F4F5FB;width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:10px;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;border-radius:20px;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#ffffff;background-color:#ffffff;width:100%;border-radius:20px;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td align="left"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <div
                                                    style="font-family:Montserrat, Helvetica, Arial, sans-serif;font-size:20px;font-weight:500;line-height:30px;text-align:left;color:#8189A9;">
                                                    Hi John, <br /> Thank you for your order.</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <div
                                                    style="font-family:Montserrat, Helvetica, Arial, sans-serif;font-size:16px;font-weight:400;line-height:20px;text-align:left;color:#8189A9;">
                                                    <p>Your order (#2233343) was successfully placed and your payment
                                                        has been processed. Here is your order summary: </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="background:#F4F5FB;background-color:#F4F5FB;margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#F4F5FB;background-color:#F4F5FB;width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:10px;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;border-radius:20px;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#ffffff;background-color:#ffffff;width:100%;border-radius:20px;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td align="left" class="receipt-table"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <table cellpadding="0" cellspacing="0" width="100%" border="0"
                                                    style="color:#8189A9;font-family:Montserrat, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                    <tbody>
                                                        <tr>
                                                            <th colspan="3"
                                                                style="font-size: 20px; line-height: 30px; font-weight: 500; text-align: center; border-bottom: 2px solid #ddd; padding: 0 0 20px 0;"
                                                                align="center">Order summary </th>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; width: 60%; padding-top: 10px;"
                                                                width="60%"> Somme en espece </td>
                                                            <td style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; text-align: right; width: 20%;"
                                                                width="20%" align="right"></td>
                                                            <td style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; text-align: right; width: 20%;"
                                                                width="20%" align="right">0 DH</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal;">
                                                                Somme par virement </td>
                                                            <td style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; text-align: right; padding: 0 0 10px;"
                                                                align="right"></td>
                                                            <td style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; text-align: right; padding: 0 0 10px;"
                                                                align="right"> DH</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; border-bottom-width: 1px; border-bottom-color: #ddd; border-bottom-style: solid; padding-top: 10px;">
                                                            </td>
                                                            <td
                                                                style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; border-bottom-width: 1px; border-bottom-color: #ddd; border-bottom-style: solid; padding-top: 10px;">
                                                            </td>
                                                            <td
                                                                style="font-size: 15px; line-height: 22px; font-weight: 400; word-break: normal; border-bottom-width: 1px; border-bottom-color: #ddd; border-bottom-style: solid; padding-top: 10px;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="word-break: normal; font-size: 20px; line-height: 30px; border-top: 1px solid #ddd; font-weight: 500; padding: 10px 0px 0px 0px; text-align: left;"
                                                                colspan="2" align="left">Total</td>
                                                            <td style="word-break: normal; font-size: 20px; line-height: 30px; border-top: 1px solid #ddd; font-weight: 500; text-align: right; padding: 10px 0px 0px 0px;"
                                                                align="right"> DH</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="background:#F4F5FB;background-color:#F4F5FB;margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#F4F5FB;background-color:#F4F5FB;width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:10px;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="background:#edeef6;background-color:#edeef6;margin:0px auto;border-radius:20px;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#edeef6;background-color:#edeef6;width:100%;border-radius:20px;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td align="center"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                    role="presentation" style="float:none;display:inline-table;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding:4px;">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    role="presentation"
                                                                    style="border-radius:3px;width:24px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td
                                                                                style="font-size:0;height:24px;vertical-align:middle;width:24px;">
                                                                                <a href="#" target="_blank"
                                                                                    style="color: #0078be; text-decoration: none; font-weight: 500;">
                                                                                    <img alt="IntelliManage"
                                                                                        height="24"
                                                                                        src="/assets/images/mylogo.png"
                                                                                        style="border-radius:3px;display:block;"
                                                                                        width="24" />
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <div
                                                    style="font-family:Montserrat, Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;line-height:22px;text-align:center;color:#8189A9;">
                                                    © 2023 [IntelliManage]</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <div
                                                    style="font-family:Montserrat, Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;line-height:22px;text-align:center;color:#8189A9;">
                                                    Vous recevez cet e-mail de chez
                                                    <a class="footer-link" href=""
                                                        style="color: #0078be; text-decoration: none; font-weight: 500;">
                                                        IntelliManage
                                                    </a> . Si vous avez des questions, contactez-nous à l'adresse
                                                    suivante : 
                                                    <a class="footer-link" href=""
                                                        style="color: #0078be; text-decoration: none; font-weight: 500;">
                                                          prime.cee.eclairage@gmail.com   </a>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="font-size:0px;word-break:break-word;">
                                                <div style="height:1px;">   </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
