<input 
    type="checkbox" 
    class="toggle toggle-md toggle-info" 

    @if(filled($items ?? []))
        @foreach ($items as $key => $value)
            {{ $key }}="{{ $value }}" 
        @endforeach
    @endif

    @if(isset($selected) && $selected)
        checked
    @endif
    
    @if(isset($disabled) && $disabled)
        disabled
    @endif
/>