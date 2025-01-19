<div class="flex items-center gap-3">
    <div class="avatar">
        <div class="mask mask-squircle w-12 h-12">
            <img src="{{ asset_bind($gateway->icon ?? "") }}" alt="{{ $gateway->title }}" loading="lazy" />
        </div>
    </div>
    <div>
        <div class="font-bold">
            {{ $gateway->title }}
        </div>
    </div>
</div>