@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Coin Purchase Confirmation'))
@section('header', __('Coin Purchase Confirmation'))

@section('content')
    <h2 class="text-2xl font-bold mb-4">Hello, {{ $user->name ?? '' }}!</h2>
    <p class="text-base-content mb-4">
        We are pleased to inform you that your recent coin purchase has been completed successfully. Below are the details of your transaction:
    </p>

    <div class="bg-base-300 p-4 rounded-lg mb-4">
        <p><strong>Purchase Date:</strong> {{ date('Y-m-d H:i', strtotime($coinOrder->created_at ?? '')) }}</p>
        <p><strong>Coin:</strong> {{ $coinOrder->coin ?? '' }}</p>
        <p><strong>Current Rate:</strong> 1 {{ $coinOrder->coin ?? '' }} = {{ $coinOrder->rate ?? '' }} {{ $coinOrder->currency_code ?? '' }}</p>
        <p><strong>Coin Amount Purchased:</strong> {{ $coinOrder->amount ?? '' }} {{ $coinOrder->coin ?? '' }}</p>
        <p><strong>Amount Paid:</strong> {{ $coinOrder->net_price ?? '' }} {{ $coinOrder->currency_code ?? '' }}</p>
        <p><strong>Transaction Fees:</strong> {{ $coinOrder->fees ?? '' }} {{ $coinOrder->currency_code ?? '' }}</p>
        <p><strong>Total Paid:</strong> {{ $coinOrder->total_price ?? '' }} {{ $coinOrder->currency_code ?? '' }}</p>
    </div>

    <p class="text-base-content mb-4">
        Your purchased coins have been added to your wallet. You can view or manage your balance by logging into your account.
    </p>
@endsection