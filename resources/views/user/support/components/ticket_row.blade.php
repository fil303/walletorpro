<tr class="">
    <td>{{ $ticket->subject }}</td>
    <td>
        @php
            $priority = _t($ticket->priority->value);
            $priority = strtoupper($priority);

            $color = match ($ticket->priority) {
                App\Enums\SupportTicketPriority::HIGH => "error",
                App\Enums\SupportTicketPriority::LOW => "ghost",
                App\Enums\SupportTicketPriority::MEDIUM => "info",
                default => "primary"
            };

            $priority = "<div class=\"badge badge-$color badge-outline\">$priority</div>";
        @endphp
        {!! $priority ?? '' !!}
    </td>
    <td>
        @php
            $status = _t($ticket->status->value);
            $status = strtoupper($status);
            
            $color = match ($ticket->status) {
                App\Enums\SupportTicketStatus::PENDING => "primary",
                App\Enums\SupportTicketStatus::CLOSED => "ghost",
                App\Enums\SupportTicketStatus::OPEN => "primary",
                App\Enums\SupportTicketStatus::ANSWERED => "info",
                default => "primary"
            };
            
            $status = "<div class=\"badge badge-$color badge-outline\">$status</div>";
        @endphp
        {!! $status ?? '' !!}
    </td>
    <td>{{ Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->updated_at)->diffForHumans() }}</td>
    <td>{{ $ticket->created_at }}</td>
    <td>
        <a href="{{ route('supportTicketPage', $ticket->ticket) }}" class="btn btn-primary">Details</a>
    </td>
</tr>