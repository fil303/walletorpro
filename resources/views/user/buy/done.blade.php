@extends('layout.app')

@section('title', __('Buy Crypto'))

@section('content')

    <div class="mt-1"></div>
    <div class="card">
        <div class="card-title h2 text-center">{{ __('Buy Crypto') }}</div>
        <div class="divider"></div>
        <div class="w-2/5 h-4/5 mx-auto py-10 sm:w-4/5 p-3">
            <div class="">
                <div style=" align-items: center">

                    <lottie-player src="https://lottie.host/a4b37462-2a54-498f-b47d-4ce91c9f1f89/l6UcKuuRw6.json"
                        class="mx-auto" background="##FFFFFF" speed="1"
                        style="width: 50%; height: 50%; align-items: center" autoplay direction="1" mode="normal">
                    </lottie-player>
                </div>
            </div>
            <div class="text-center">{{ __('You successfully purchased') }}</div>
            <div class="text-center">
                <button class="btn btn-primary mt-2">{{ __('Return to Buy History') }}</button>
            </div>
        </div>

    </div>

@endsection
@section('downjs')
    <script>
        async function getCryptoPrice(value) {
            let crypto = document.getElementsByName("crypto")[0].value;
            let currency = document.getElementsByName("currency")[0].value;
            let amount = document.getElementsByName("amount")[0].value;
            let returnValue = 0;
            await $.get(
                '{{ route('cryptoBuyPrice') }}', {
                    crypto: crypto,
                    currency: currency,
                    amount: amount,
                },
                (response) => {
                    document.bind.bindTo('convert_amount', response.data.total);
                    returnValue = response.data.price;
                }
            )
            return returnValue;
        }
    </script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection
