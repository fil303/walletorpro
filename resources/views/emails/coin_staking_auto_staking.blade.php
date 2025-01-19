@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Coin Auto Staking Start'))
@section('header', __('Coin Auto Staking Start'))

@section('content')

    <h2 class="text-2xl font-bold mb-4">Hello, {{ $user->name }}!</h2>
    <p class="text-base-content mb-4">
        Great news! Your coin staking period has automatically started for another cycle. Here are the details of your new staking transaction:
    </p>

    <div class="bg-base-300 p-4 rounded-lg mb-4">
        <p><strong>Coin Staked:</strong> {{ $stake->coin ?? 'USDT' }}</p>
        <p><strong>Staked Amount:</strong> {{ $stake->amount ?? '0' }} {{ $stake->coin ?? 'USDT' }}</p>
        <p><strong>Staking Duration:</strong> {{ $stake->duration ?? '0' }} {{__("days")}}</p>
        <p><strong>Interest Rate:</strong> {{ $stake->interest ?? '0' }}%</p>
        <p><strong>Expected Return Amount:</strong> {{ (($stake->amount ?? '0') + ($stake->interest_amount ?? '0')) }} {{ $stake->coin ?? 'USDT' }}</p>
        <p><strong>New Staking Start Date:</strong> {{ date('Y-m-d H:i', strtotime($stake->created_at ?? '')) }}</p>
        <p><strong>New Staking End Date:</strong> {{ date('Y-m-d H:i', strtotime($stake->end_at ?? '')) }}</p>
    </div>

    <!-- Additional Message -->
    <p class="text-base-content mb-4">
        Your staking has been renewed automatically to help you continue earning rewards. You can modify or stop the auto-staking option anytime by visiting your account settings.
    </p>

@endsection