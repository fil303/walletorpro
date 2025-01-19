@if(isset($items[0]) && isset($items[0]->key) && isset($items[0]->value))
    @foreach ($items as $item)        
        <option 
            value="{{ $item->key }}"

            @if(isset($seleted_item) && (($seleted_item ?? "") == $item->key))
                selected
            @endif

            @if(isset($attrs))
              @foreach ($attrs as $attr => $value) 
                {{ $attr }}="{{ $value }}"
              @endforeach
            @endif

        >{{ $item->value }}</option>
    @endforeach
@endif