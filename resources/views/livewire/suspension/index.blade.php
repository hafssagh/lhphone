<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
       @include("livewire.suspension.create")
    @endif
    @if ($currentPage == PAGEEDITFORM)
       @include("livewire.suspension.edit")
    @endif
    @if ($currentPage == PAGELIST)
       @include("livewire.suspension.liste")
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