<div class="chat chat-end  m-4">
    <div class="chat-image avatar">
      <div class="w-10 rounded-full">
        <img alt="Tailwind CSS chat bubble component" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
      </div>
    </div>
    <div class="chat-header">
      {{ __("You") }}
      <time class="text-xs opacity-50">12:46</time>
    </div>
    <div class="chat-bubble">
        {{ $replay->message }}

    </div>
</div>