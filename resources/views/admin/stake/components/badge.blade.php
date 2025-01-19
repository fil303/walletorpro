@if(isset($segments))
    @foreach ($segments as $segment)
        <div class="badge badge-info gap-2">
            {{ $segment->duration }} {{ isset($interest)? '%': 'D' }}
        </div>
    @endforeach
@endif
