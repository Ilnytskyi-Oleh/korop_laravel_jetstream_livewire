<span class="ml-4 mr-4">
     <input type="checkbox" name="saved"
     @if(request('saved') == 'on') checked @endif
     > Saved({{ $saved }})
</span>
