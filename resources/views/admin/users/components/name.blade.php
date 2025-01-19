<div class="flex items-center gap-3">
    <div class="avatar">
    <div class="mask mask-squircle w-12 h-12">
        <img src="{{ $user->getImage() ?? '' }}" alt="{{ $user->name }}" loading="lazy" />
    </div>
    </div>
    <div>
    <div class="font-bold">{{ $user->name }}</div>
    <div class="text-sm opacity-50">{{'@' . $user->username }}</div>
    </div>
</div>