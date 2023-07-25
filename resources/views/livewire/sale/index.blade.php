<div wire:ignore.self>
    @if ($currentPage == PAGELIST)
        @include('livewire.sale.liste')
    @endif
    @if ($currentPage == PAGECREATEFORM)
        @include('livewire.sale.create')
    @endif
    @if ($currentPage == PAGEEDITFORM)
        @include('livewire.sale.edit')
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
