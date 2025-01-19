@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Coin Exchange Successful'))
@section('header', __('Coin Exchange Successful'))

@section('content')
    <h2 class="text-2xl font-bold mb-4">Hello, {{ $user->name }}!</h2>
    <p class="text-base-content mb-4">
        Your recent coin exchange has been completed successfully. Below are the details of your transaction:
    </p>

    <div class="bg-base-300 p-4 rounded-lg mb-4">
        <p><strong>Coin Pair:</strong> {{ $exchange->from_coin }} {{__("to")}} {{ $exchange->to_coin }}</p>
        <p><strong>Current Exchange Rate:</strong> 1 {{ $exchange->from_coin }} = {{ $exchange->rate }} {{ $exchange->to_coin }}</p>
        <p><strong>Amount Exchanged:</strong> {{ $exchange->from_amount }} {{ $exchange->from_coin }}</p>
        <p><strong>Converted Amount:</strong> {{ $exchange->to_amount }} {{ $exchange->to_coin }}</p>
        <p><strong>Transaction Fees:</strong> {{ $exchange->fee ?? '0' }} {{ $exchange->to_coin }}</p>
    </div>
@endsection