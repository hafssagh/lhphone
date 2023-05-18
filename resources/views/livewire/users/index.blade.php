  <div wire:ignore.self>
      @if ($currentPage == PAGECREATEFORM)
         @include("livewire.users.create")
      @endif
      @if ($currentPage == PAGEEDITFORM)
         @include("livewire.users.edit")
      @endif
      @if ($currentPage == PAGELIST)
         @include("livewire.users.liste")
      @endif
      @if ($currentPage == PAGEROLE)
         @include("livewire.users.role")
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
               @this.deleteUser(event.detail.message.data.user_id)
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