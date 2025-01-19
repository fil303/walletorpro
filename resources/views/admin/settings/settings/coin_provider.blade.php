@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Email Setting'))

@section('content')

    <div class="flex justify-between">
        <h2 class="card-title">{{ __('Coin Payment Configuration') }}</h2>
        <a href="{{ route('settingPage') }}" class="btn">
            <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 14 4 9l5-5" />
                <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
            </svg>
            {{ __("Button") }}
        </a>
    </div>
    <div class="divider"></div>

        <!-- Settings Card -->
        <div class="card bg-base-100 shadow-xl p-6 rounded-lg">
            <form action="{{ route('coinProviderCoinPaymentSave') }}" method="post">@csrf
                <div class="grid grid-cols-2 gap-4">
                
                    <!-- Public Key -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">
                                Public Key
                                <span class="text-error">*</span>
                            </span>
                        </label>
                        <input name="public_key" type="text" value="{{ $app->coin_payment_public_key ?? '' }}" placeholder="Enter your CoinPayment Public Key" class="input input-bordered w-full" required />
                    </div>

                    <!-- Private Key -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">
                                Private Key
                                <span class="text-error">*</span>
                            </span>
                        </label>
                        <input name="private_key" value="{{ $app->coin_payment_private_key ?? '' }}" type="password" placeholder="Enter your CoinPayment Private Key" class="input input-bordered w-full" required />
                    </div>

                    <!-- Merchant ID -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">
                                Merchant ID
                                <span class="text-error">*</span>
                            </span>
                        </label>
                        <input name="ipn_marchant" type="text" value="{{ $app->coin_payment_ipn_marchant ?? '' }}" placeholder="Enter your Merchant ID" class="input input-bordered w-full" required />
                    </div>

                    <!-- IPN Secret Key -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">
                                IPN Secret Key
                                <span class="text-error">*</span>
                            </span>
                        </label>
                        <input name="ipn_secret" type="text" value="{{ $app->coin_payment_ipn_secret ?? '' }}" placeholder="Enter IPN Secret Key for secure callbacks" class="input input-bordered w-full" required />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary w-full">{{ __("Save Settings") }}</button>
                    </div>
                    <div class="form-control mt-6">
                        <a href="{{ route('settingPage') }}" class="btn btn-error w-full">{{  __("Back To Setting Dashboard") }}</a>
                    </div>
                </div>
            </form>
        </div>
@endsection
