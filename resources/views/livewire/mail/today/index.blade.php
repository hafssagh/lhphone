<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
        @include('livewire.mail.today.create')
    @endif
    @if ($currentPage == PAGELIST)
        @include('livewire.mail.today.liste')
    @endif
    @if ($currentPage == PAGEEDITFORM)
        @include('livewire.mail.edit')
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

<script>
    window.addEventListener('showErrorMessage', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast: 'error',
            title: event.detail.message || "Opération échouée",
            showConfirmButton: false,
            timer: 5000
        })
    });
</script>
