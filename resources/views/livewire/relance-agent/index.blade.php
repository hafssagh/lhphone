<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
       @include("livewire.relance-agent.create")
    @endif
    @if ($currentPage == PAGELIST)
       @include("livewire.relance-agent.liste")
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

