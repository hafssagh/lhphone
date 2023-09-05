<div wire:ignore.self>
    @if ($currentPage == PAGELIST)
        @include('livewire.renovation.liste')
    @endif
    @if ($currentPage == PAGECREATEFORM)
        @include('livewire.renovation.create')
    @endif
    @if ($currentPage == PAGEEDITFORM)
        @include('livewire.renovation.edit')
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