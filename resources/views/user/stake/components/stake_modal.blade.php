<input type="hidden" name="plan" value="{{ $stake->id }}">
<h2 class="mb-2">
    {{__("Duration")}}
    <span class="text-error">*</span>
</h2>
<div class="grid grid-cols-3 gap-4">
    @if(isset($stake->segments[0]))
        @foreach($stake->segments as $segment)
            <div class="card bg-base-100 shadow-xl border border-base-100 hover:border-primary focus:border-primary" tabindex="1" onclick="document.getElementById('segment_id_{{ $segment->id }}').click()">
                <div class="card-body p-4">
                    <input type="radio" name="segment" id="segment_id_{{ $segment->id }}" value="{{ $segment->id }}" class="mb-0" />
                    <p class="text-center text-xl">{{ $segment->duration ?? 1 }} Days</p>
                    <p class="text-center hover:text-primary">{{ $segment->interest }}% APY</p>
                </div>
            </div>
        @endforeach
    @endif

</div>

<h2 class="mb-2 mt-5">
    {{ __('Amount') }}
    <span class="text-error">*</span>
</h2>
<div class="join">
    <div>
        <div>
            <input name="amount" id="stake_amount" class="input focus:outline-none border input-bordered w-full join-item" />
        </div>
    </div>
    <button type="button" onclick="document.getElementById('stake_amount').value = '{{ $stake->max ?? 0 }}'" class="btn btn-primary join-item">Max</button>
    <div class="indicator">
        <span class="btn join-item" disabled>
            <img  height="35px" width="35px" src="{{ $coin->getIcon() }}" />
            {{ $stake->coin ?? 'USDT' }}
        </span>
    </div>
</div>
<div class="mt-2">Available: <span class="text-primary">{{ to_coin((int)$wallet->balance ?? 0, $wallet->decimal ?? 18) }} {{ $stake->coin ?? 'USDT' }}</span></div>

<div class="divider"></div>
<div class="flex">
    <div>
        <img class="p-1 bg-primary rounded" src="{{ asset_bind('assets/lucide/bar.svg') }}" />
    </div>
    <div class="ml-5">
        <h2 class="text-xl mb-2">{{ __('Locked Amount Limit') }}</h2>
        <span>{{ __('Minimum') }}</span> : <span>{{ $stake->min }} {{ $stake->coin ?? 'USDT' }}</span><br>
        <span>{{ __('Maximum') }}</span> : <span>{{ $stake->max }} {{ $stake->coin ?? 'USDT' }}</span>
    </div>
</div>


<div class="divider"></div>
<div class="flex">
    <div>
        <img class="p-1 bg-primary rounded" width="50px" src="{{ asset_bind('assets/lucide/rotate.svg') }}" />
    </div>
    <div class="ml-5">
        <h2 class="text-xl mb-2">{{ __('Auto Staking') }}</h2>
        <p>Enable auto-staking to automatically restake a products that has expired to its previous staking</p>
    </div>
    <div>
        {!! view('admin.components.toggle', [ "items" => [ "name" => "auto" ] ]) !!}
    </div>
</div>