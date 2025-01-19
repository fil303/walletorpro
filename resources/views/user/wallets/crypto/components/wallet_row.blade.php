@use(App\Enums\FileDestination)
<div class="card bg-base-100 shadow-xl">
  <div class="card-body">
    <div class="flex justify-between mb-1">
      <div class="flex items-center gap-3">
        <div class="avatar">
          <div class="mask mask-squircle w-12 h-12">
            <img src="{{ $wallet->coin_parent_table?->getIcon() }}" alt="{{ $wallet->name ?? '' }}" loading="lazy" />
          </div>
        </div>
        <div>
          <div class="badge badge-ghost text-sm opacity-50">{{ isset($wallet->coin->type) && $wallet->coin_parent_table->type == 'f' ? __("Fiat"): __("Crypto") }}</div>
          <div class="font-bold">{{ $wallet->coin_parent_table->name ?? "" }}</div>
        </div>
      </div>
      <div>
          <span>Balance</span>
          <br/>
          <span class="text-xl">{{ print_coin(($wallet->balance ?? 0), $wallet->coin_parent_table->print_decimal ?? 8) }} {{ $wallet->coin ?? 'BTC' }}</span>
      </div>
    </div>
    <div class="flex justify-center mt-1">
      <div>
          <a href="{{ route('coinBuyPage', ['coin' => $wallet->coin ?? 'BTC' ]) }}" class="btn btn-sm btn-success">Buy {{ $wallet->coin ?? 'BTC' }}</a>
          <a href="{{ route('cryptoWalletWithdrawalPage', ['coin' => $wallet->coin ?? 'BTC', 'uid' => $wallet->coin_parent_table->uid ?? 0]) }}" class="btn btn-sm">Withdrawal</a>
          <a href="{{ route('cryptoWalletDepositPage',['coin' => $wallet->coin ?? 'BTC', 'uid' => $wallet->coin_parent_table->uid ?? 0]) }}" class="btn btn-sm">deposit</a>
      </div>
    </div>
  </div>
</div>
