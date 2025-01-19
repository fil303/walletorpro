<tr>
    <th>{{ print_coin($coinExchange->from_amount ?? 0, $coinExchange->f_coin?->print_decimal ?? 8) }} {{ $coinExchange->from_coin ?? 'USDT' }}</th>
    <th>{{ print_coin($coinExchange->to_amount   ?? 0, $coinExchange->t_coin?->print_decimal ?? 8) }} {{  $coinExchange->to_coin   ?? 'USDT' }}</th>
    <th>{{ print_coin($coinExchange->rate        ?? 0, $coinExchange->t_coin?->print_decimal ?? 8) }} {{ $coinExchange->to_coin   ?? 'USDT' }}</th>
    <th>{{ print_coin($coinExchange->fee         ?? 0, $coinExchange->f_coin?->print_decimal ?? 8) }} {{ $coinExchange->from_coin ?? 'USDT' }}</th>
    <th>{{ date('M d, Y, h:i A', strtotime($coinExchange->created_at ?? '')) }}</th>
</tr>