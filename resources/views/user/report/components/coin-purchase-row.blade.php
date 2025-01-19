<tr>
    <th>
        {!! view('admin.coins.crypto.components.name', ['coin' => $coinOrder->coin_table ?? null]) !!}
    </th>
    <th>{{ trim_number($coinOrder->rate ?? '') }} {{ $coinOrder->currency_code ?? 'USD' }}</th>
    <th>{{ trim_number($coinOrder->amount  ?? 0) }} {{ $coinOrder->coin ?? 'USDT' }}</th>
    <th>{{ trim_number($coinOrder->fee  ?? 0) }} {{ $coinOrder->currency_code ?? 'USD' }}</th>
    <th>{{ trim_number($coinOrder->total_price  ?? 0) }} {{ $coinOrder->currency_code ?? 'USD' }}</th>
    <th>{{ $coinOrder->payment?->title ?? 'N/A' }}</th>
    <th>{{ $coinOrder->transaction_id ?? 'N/A' }}</th>
    <th>
        @php
            $status = App\Enums\CoinBuyStatus::tryFrom($coinOrder->status ?? 3);
            $color = match ($status) {
                App\Enums\CoinBuyStatus::COMPLETED => "primary",
                App\Enums\CoinBuyStatus::WAITING => "info",
                default => "primary"
            };
            $status = $status?->status() ?? 'N/A';
            $status = "<div class=\"badge badge-$color badge-outline\">$status</div>";
        @endphp
        {!! $status !!}
    </th>
    <th>{{ date('M d, Y, h:i A', strtotime($coinOrder->created_at ?? '')) }}</th>
</tr>