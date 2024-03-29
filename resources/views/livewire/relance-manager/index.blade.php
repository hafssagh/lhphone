<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
       @include("livewire.relance-manager.create")
    @endif
    @if ($currentPage == PAGELIST)
       @include("livewire.relance-manager.liste")
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
            timer: 3000
        })
    });
</script>
