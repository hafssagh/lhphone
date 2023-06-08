<div wire:ignore.self>
    @if ($currentPage == PAGECREATEFORM)
       @include("livewire.mail.create")
    @endif
    @if ($currentPage == PAGELIST)
       @include("livewire.mail.liste")
    @endif  
</div>