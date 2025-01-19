@use(App\Enums\TransactionType)
<tr>
    <th>
        {!!
            match ($deposit->type) {
                TransactionType::INTERNAL => '<span class="badge badge-success">'._t("Internal").'</span>',
                TransactionType::EXTERNAL => '<span class="badge badge-warning">'._t("External").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            }
        !!}
    </th>
    <th>{{ $deposit->from_address ?? '' }}</th>
    <th>{{ print_coin($deposit->amount  ?? 0, $deposit->coin_table->print_decimal ?? 8) }} {{ $deposit->coin ?? 'USDT' }}</th>
    <th>{{ $deposit->trx     ?? '' }}</th>
    <th>{{ date('M d, Y, h:i A', strtotime($deposit->created_at ?? '')) }}</th>
</tr>