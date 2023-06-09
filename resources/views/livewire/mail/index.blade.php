<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
        @include('livewire.mail.create')
    @endif
    @if ($currentPage == PAGELIST)
        @include('livewire.mail.liste')
    @endif
    @if ($currentPage == PAGEPOPOSWEEK)
        @include('livewire.mail.proposWeek')
    @endif
    @if ($currentPage == PAGEPOPOSMONTH)
        @include('livewire.mail.proposMonth')
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
