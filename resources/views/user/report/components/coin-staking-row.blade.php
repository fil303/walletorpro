<tr>
    <th>{!! view('admin.coins.crypto.components.name', ['coin' => $plan->plan_coin ?? null]) !!}</th>
    <th>{{ $plan->amount }} {{ $plan->coin }}</th>
    <th>{{ $plan->interest }} {{ $plan->coin }}</th>
    <th>{{ $plan->amount + $plan->interest_amount }} {{ $plan->coin }}</th>
    <th>{{ $plan->created_at }}</th>
    <th>{{ $plan->end_at }}</th>
    <th>{{ $plan->status }}</th>
</tr>