@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Password Reset'))
@section('header', __('Password Reset'))

@section('content')

    <h2 class="text-2xl font-bold mb-4">Hello, {{ $user->name }}!</h2>
    <p class="text-base-content mb-4">
        We received a request to reset your password. If you didn’t make the request, just ignore this email. Otherwise, you can reset your password using the button below:
    </p>
    
    <div class="text-center my-6">
        <a href="{{ $url }}" class="btn btn-primary">
            Reset Your Password
        </a>
    </div>

    <p class="text-base-content">
        If you have any questions, feel free to contact our support team at [Support Email].
    </p>

@endsection