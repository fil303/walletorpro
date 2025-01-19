@use(App\Enums\TransactionType)
<tr>
    <th>
        {!!
            match ($withdrawal->type) {
                TransactionType::INTERNAL => '<span class="badge badge-success">'._t("Internal").'</span>',
                TransactionType::EXTERNAL => '<span class="badge badge-warning">'._t("External").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            }
        !!}
    </th>
    <th>{{ $withdrawal->to_address ?? '' }}</th>
    <th>{{ $withdrawal->coin ?? 'N/A' }}</th>
    <th>{{ $withdrawal->amount  ?? 0 }} {{ $withdrawal->coin ?? 'USDT' }}</th>
    <th>{{ $withdrawal->trx ?? 'N/A' }}</th>
    <th>{{ date('M d, Y, h:i A', strtotime($withdrawal->created_at ?? '')) }}</th>
</tr>