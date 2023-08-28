<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
       @include("livewire.conge.create")
    @endif
    @if ($currentPage == PAGEEDITFORM)
       @include("livewire.conge.edit")
    @endif
    @if ($currentPage == PAGELIST)
       @include("livewire.conge.liste")
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

