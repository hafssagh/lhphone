<div wire:ignore.self>
    @if($editResignation != [])
        @include("livewire.resignation.edit")
    @endif
        @include("livewire.resignation.liste")
    

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

<script>
    window.addEventListener("showModal", event=>{
       $("#editModal").modal("show")
    })

    window.addEventListener("closeModal", event=>{
       $("#editModal").modal("hide")
    })
</script>


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
                @this.deleteResignation(event.detail.message.data.resignation_id)
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