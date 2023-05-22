
@can("admin")
<div wire:ignore.self>
  @if ($currentPage == PAGECREATEFORM)
     @include("livewire.absence.create")
  @endif
   @if ($currentPage == PAGEEDITFORM)
     @include("livewire.absence.edit")
  @endif 
  @if ($currentPage == PAGELIST)
     @include("livewire.absence.liste")
  @endif
</div>
@endcan

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
  window.addEventListener("showAbsModal", event=>{
     $("#addModal").modal("show")
  })

  window.addEventListener("closeAbsModal", event=>{
     $("#addModal").modal("hide")
  })
</script>

<script>
   window.addEventListener('showConfirmMessage', event => {
       Swal.fire({
           text: event.detail.message.text,
           icon: event.detail.message.type,
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Continuer',
           cancelButtonText: 'Annuler'
       }).then((result) => {
           if (result.isConfirmed) {
               @this.deleteAbsence(event.detail.message.data.resignation_id)
           }
       })
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
   });
</script>
