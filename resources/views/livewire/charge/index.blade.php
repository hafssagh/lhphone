<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
        @include('livewire.charge.create')
    @endif
    @if ($currentPage == PAGECREATEFORM2)
        @include('livewire.charge.create2')
    @endif
    @if ($currentPage == PAGELIST)
        @include('livewire.charge.liste')
    @endif
    @if ($currentPage == PAGEEDITFORM)
        @include('livewire.charge.edit')
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
