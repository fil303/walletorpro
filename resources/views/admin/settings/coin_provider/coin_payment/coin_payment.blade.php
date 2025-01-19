@extends("layout.app")

@section('title', __("Email Setting"))

@section("content")

    <h2 class="card-title">{{  __('Coin Payment')  }}</h2>
    <div class="divider"></div>
    <form action="{{ route('coinPaymentSettingUpdate') }}" method="post">
        @csrf
        <div class="grid sm:block">
            <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __("Public Key") }}</span>
                    </div>
                    <input name="public_key" type="text" value="{{ $settings->coin_payment_public_key ?? '' }}" placeholder="{{ __('Public Key') }}" class="input input-bordered" />
                </label>

                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __("Private Key") }}</span>
                    </div>
                    <input name="private_key" type="text" value="{{ $settings->coin_payment_private_key ?? '' }}" placeholder="{{ __('Private Key') }}" class="input input-bordered" />
                </label>

                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __("IPN Merchant ID") }}</span>
                    </div>
                    <input name="ipn_marchant" type="text" value="{{ $settings->coin_payment_ipn_marchant ?? '' }}" placeholder="{{ __('IPN Merchant ID') }}" class="input input-bordered" />
                </label>

                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __("IPN Secret") }}</span>
                    </div>
                    <input name="ipn_secret" type="text" value="{{ $settings->coin_payment_ipn_secret ?? '' }}" placeholder="{{ __('IPN Secret') }}" class="input input-bordered" />
                </label>
                
                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __("Auto Withdrawal") }}</span>
                    </div>
                    <select name="auto_withdrawal" class="select select-bordered">
                        {!! App\Enums\Status::renderOption($settings->coin_payment_auto_withdrawal ?? 0) !!}
                    </select>
                </label>
            </div>
        </div>

        <div class="card-actions justify-start sm:justify-center mt-2">
            <button type="submit" class="btn btn-primary">{{ __("Update") }}</button>
        </div>
    </form>

@endsection