<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
       @include("livewire.explic.create")
    @endif
    @if ($currentPage == PAGELIST)
       @include("livewire.explic.liste")
    @endif
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
