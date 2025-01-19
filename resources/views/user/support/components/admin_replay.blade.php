<div class="chat chat-start m-4">
    <div class="chat-image avatar">
        <div class="w-10 rounded-full">
            <img alt="Tailwind CSS chat bubble component"
                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
        </div>
    </div>
    <div class="chat-header">
        {{ __('Admin') }}
        <time class="text-xs opacity-50">2 hours ago</time>
    </div>
    <div class="chat-bubble">
        {{ $replay->message }}
        <br><br>
        @if(isset($replay->attachmentData[0]))
            @foreach ($replay->attachmentData as $attachment)
                <a 
                    class="btn btn-sm btn-info mb-1" 
                    href="{{ route('supportTicketAttachmentDownload',[ 'replay' => $replay->id, 'index' => $loop->index ]) }}"
                >
                    {{  __("Attachment")." ". ++$loop->index}}
                </a>
            @endforeach
        @endif
    </div>
</div>
