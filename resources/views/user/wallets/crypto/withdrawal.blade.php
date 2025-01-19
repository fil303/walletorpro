@extends('layout.app', [ "menu" => "wallet" ])

@section('title', __('My Crypto Wallets'))
@use(App\Enums\WithdrawalStatus)
@section('content')
    <div class="container mx-auto p-4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between">
                    <h2 class="card-title"></h2>
                    <a href="{{ route('cryptoWalletPage') }}" class="btn">
                        <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 14 4 9l5-5" />
                            <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                        </svg>
                        {{ __("Button") }}
                    </a>
                </div>
                <!-- Wallet Header -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="avatar">
                        <div class="mask mask-squircle w-12 h-12">
                            <img src="{{ $coin->getIcon() }}" alt="{{ $coin->name ?? '' }}" loading="lazy" />
                        </div>
                    </div>
                    <div>
                        <h2 class="card-title">{{ $coin->name ?? '' }} Withdrawal</h2>
                        <div class="text-lg">{{ __('Available Balance') }}: <span
                                class="font-bold">{{ print_coin($wallet->balance ?? 0, $coin->print_decimal ?? 8) }}
                                {{ $coin->coin ?? 'BTC' }}</span></div>
                    </div>
                </div>

                <form action="{{ route('cryptoWalletWithdrawal') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="wallet" value="{{ $wallet->uid ?? '' }}">
                    <input type="hidden" name="coin_code" value="{{ $coin->code ?? '' }}">
                    @if ($multiNetworkCoin ?? false)
                        <!-- Network Selection -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">
                                    {{ __('Select Network') }}
                                    <span class="text-error">*</span>
                                </span>
                            </label>
                            <select class="select select-bordered w-full" name="network" required>
                                <option value="" disabled selected>{{ __('Choose a network') }}</option>
                                {!! view('admin.components.select_option', ['items' => $coins ?? [], 'seleted_item' => $coin->code ?? null]) !!}
                            </select>
                        </div>
                    @endif

                    <!-- Recipient Address -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">
                                {{ __('Recipient Address') }}
                                <span class="text-error">*</span>
                            </span>
                        </label>
                        <input type="text" name="address" class="input input-bordered" placeholder="Enter wallet address"
                            required />
                    </div>

                    <!-- Memo Field -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('Memo (Optional)') }}</span>
                        </label>
                        <input type="text" name="memo" class="input input-bordered"
                            placeholder="Enter memo if required" />
                    </div>

                    <!-- Amount Field -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">
                                {{ __('Amount') }}
                                <span class="text-error">*</span>
                            </span>
                            <span class="label-text-alt">Min: {{ print_coin($coin->withdrawal_min ?? '0.000', $coin->print_decimal ?? 8) }}
                                {{ $coin->coin ?? 'BTC' }} | Max: {{ print_coin($coin->withdrawal_max ?? '0', $coin->print_decimal ?? 8) }}
                                {{ $coin->coin ?? 'BTC' }}</span>
                        </label>
                        <div class="input-group">
                            <input type="number" step="any" name="amount" class="input input-bordered w-full"
                                placeholder="Enter amount to withdraw" required />
                        </div>
                    </div>

                    <!-- Fee Information -->
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">Withdrawal Fee: {{ print_coin($coin->withdrawal_fees ?? '0', $coin->print_decimal ?? 8) }}{{ $coin->withdrawal_fees_type == 2? '%': '' }} {{ $coin->coin ?? 'BTC' }}
                            </h3>
                            <div class="text-xs">Please double-check the withdrawal address and network before proceeding
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Withdraw') }}
                            {{ $coin->coin ?? 'BTC' }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card bg-base-100 mt-2 shadow-xl">
            <div class="card-body">
                <div>
                    <h2 class="font-semibold text-lg mb-2">{{ __('Recent Withdrawals') }}</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Memo') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals ?? [] as $withdrawal)
                                    <tr>
                                        <td>{{ $withdrawal->to_address }}</td>
                                        <td>{{ trim_number($withdrawal->amount ?? 0) }} {{ $withdrawal->coin }}</td>
                                        <td>
                                            @if (WithdrawalStatus::PENDING === $withdrawal->status)
                                                <span class="badge badge-primary">{{ __('Pending') }}</span>
                                            @elseif(WithdrawalStatus::COMPLETED === $withdrawal->status)
                                                <span class="badge badge-success">{{ __('Confirmed') }}</span>
                                            @else
                                                <span class="badge badge-error">{{ __('Rejected') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $withdrawal->created_at }}</td>
                                        <td>N/A</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
