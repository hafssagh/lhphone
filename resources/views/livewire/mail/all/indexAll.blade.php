@if ($currentPage == PAGEEDITFORM)
@include('livewire.mail.edit')
@endif
@if ($currentPage == PAGEPOPOSALL)
@include('livewire.mail.all.proposAll')
@endif

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