@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Coin Staking Complete'))
@section('header', __('Coin Staking Complete'))

@section('content')

    <h2 class="text-2xl font-bold mb-4">Hello, {{ $user->name ?? '' }}!</h2>
    <p class="text-base-content mb-4">
        Congratulations! Your coin staking period has ended, and your rewards have been credited to your wallet. Here are the details of your staking transaction:
    </p>

    <div class="bg-base-300 p-4 rounded-lg mb-4">
        <p><strong>Coin Staked:</strong> {{ $stake->coin ?? 'USDT' }}</p>
        <p><strong>Initial Staked Amount:</strong> {{ $stake->amount ?? '0' }} {{ $stake->coin ?? 'USDT' }}</p>
        <p><strong>Staking Duration:</strong> {{ $stake->duration ?? '0' }} {{__("days")}}</p>
        <p><strong>Interest Earned:</strong> {{ $stake->interest_amount ?? '0' }} {{ $stake->coin ?? 'USDT' }}</p>
        <p><strong>Total Return Amount:</strong> {{ (($stake->amount ?? '0') + ($stake->interest_amount ?? '0')) }} {{ $stake->coin ?? 'USDT' }}</p>
        <p><strong>Staking Completion Date:</strong> {{ date('Y-m-d H:i', strtotime($stake->end_at ?? '')) }}</p>
    </div>

    <p class="text-base-content mb-4">
        Your staked amount along with the interest earned has been successfully credited to your wallet. Thank you for staking with us, and we look forward to helping you grow your assets in the future!
    </p>

@endsection