@if ($currentPage == PAGEEDITFORM)
@include('livewire.mail.edit')
@endif
@if ($currentPage == PAGEPOPOSWEEK)
@include('livewire.mail.week.proposWeek')
@endif

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