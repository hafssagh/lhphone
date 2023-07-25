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
              timer: 3000
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


<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('toggleAdditionalOption', function(isEnabled) {
            if (isEnabled) {
                document.getElementById('select2').removeAttribute('disabled');
            } else {
                document.getElementById('select2').setAttribute('disabled', 'disabled');
            }
        });
    });
</script>