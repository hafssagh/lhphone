<div wire:ignore.self>
    @if ($currentPage == PAGELIST)
        @include('livewire.appointment.liste')
    @endif
    @if ($currentPage == PAGECREATEFORM)
        @include('livewire.appointment.create')
    @endif
    @if ($currentPage == PAGEEDITFORM)
        @include('livewire.appointment.edit')
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