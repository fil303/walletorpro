<tr>
    <th>{{ $plan->coin }}</th>
    <th>{{ $plan->min }} {{ $plan->coin }}</th>
    <th>{{ $plan->max }} {{ $plan->coin }}</th>
    <th>{!! view("admin.stake.components.badge", ['segments' => $plan->segments]) !!}</th>
    <th>{!! view("admin.stake.components.badge", ['segments' => $plan->segments, 'interest' => true]) !!}</th>
    <th>
        <button 
            class="btn btn-primary btn-sm"
            data-stake-id="{{ $plan->id }}"
            data-stake-coin="{{ $plan->coin }}"
            data-stake-min="{{ $plan->min }}"
            data-stake-max="{{ $plan->max }}"
            data-stake-duration="{{ $plan->duration }}"
            data-stake-interest="{{ $plan->interest }}"
            onclick="openStakePlanHandler({{ $plan->id }})"
        >
            {{ __('Start Staking') }}
        </button>
    </th>
</tr>