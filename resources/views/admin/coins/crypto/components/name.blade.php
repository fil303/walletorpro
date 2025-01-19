<div class="flex items-center gap-3">
    <div class="avatar">
    <div class="mask mask-squircle w-12 h-12">
        <img src="{{ $coin?->getIcon() ?? '' }}" alt="{{ $coin->name ?? '' }}" loading="lazy" />
    </div>
    </div>
    <div>
    <div class="font-bold">{{ $coin->name ?? '' }}</div>
    <div class="text-sm opacity-50">{{ $coin->code ?? '' }}</div>
    </div>
</div>