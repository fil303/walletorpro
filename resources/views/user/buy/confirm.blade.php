@extends('layout.app')

@section('title', __('Buy Crypto'))

@section('content')

    <div class="mt-1"></div>
    <div class="card">
        <div class="card-title h2 text-center">{{ __('Confirm Buy Crypto') }}</div>
        <div class="divider"></div>
        <div class="w-3/5 mx-auto py-10 sm:w-4/5 p-3 glass">

            <form action="{{ route('buyCryptoProcess') }}" class="" method="POST">
                @csrf
                <input type="hidden" name="crypto" value="{{ $crypto ?? '' }}">
                <input type="hidden" name="currency" value="{{ $currency ?? '' }}">
                <input type="hidden" name="amount" value="{{ $amount ?? 0 }}">

                <div class="w-full mx-auto mb-2">
                    <div class="flex justify-between border-b-2">
                        <div>{{ __('I want to buy') }}</div>
                        <div>{{ 100 }} {{ 'BTC' }}</div>
                    </div>

                    <div class="flex justify-between border-b-2">
                        <div>1 {{ __('BTC') }}</div>
                        <div>= {{ 100 }} {{ 'USD' }}</div>
                    </div>

                    <div class="flex justify-between border-b-2">
                        <div>100 {{ __('BTC') }}</div>
                        <div>= {{ 100 }} {{ 'USD' }}</div>
                    </div>

                    <div class="flex justify-between border-b-2">
                        <div>{{ __('Service fees') }}</div>
                        <div>= {{ 100 }} {{ 'USD' }}</div>
                    </div>

                    <div class="flex justify-between border-b-2 font-bold text-info">
                        <div>{{ __('I will pay') }}</div>
                        <div>= {{ 100 }} {{ 'USD' }}</div>
                    </div>
                </div>


                <div class="card-actions justify-end">
                    <button type="submit" class="btn btn-success w-2/5">{{ __('Continue') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('downjs')
    <script></script>
@endsection
