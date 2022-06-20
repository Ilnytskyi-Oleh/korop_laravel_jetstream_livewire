
<span class=" mr-3" >
    @if($savedListing)
        <a href="#" wire:click.prevent="unsaveListing">Unsave</a>
    @else
        <a href="#" wire:click.prevent="saveListing">Save</a>
    @endif

</span>
