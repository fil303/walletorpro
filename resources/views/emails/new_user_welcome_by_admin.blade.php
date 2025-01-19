@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Welcome to'). ($app->app_name ?? ''))
@section('header', __('Welcome to'). ($app->app_name ?? ''))

@section('content')

    <h2 class="text-2xl font-bold mb-4">Hello, {{ $user->name }}!</h2>
    <p class="text-base-content mb-4">
        Welcome to {{ $app->app_name ?? 'company'}}! We are excited to have you on board. Below are your account details:
    </p>

    <div class="bg-base-300 p-4 rounded-lg mb-4">
        <p><strong>Email:</strong> {{ $user->email ?? '' }}</p>
    </div>

    <p class="text-base-content mb-4">
        To set up your password, please click the button below to reset your password:
    </p>

    <!-- Call to Action Button -->
    <div class="text-center my-6">
        <a href="{{ route('forgotPasswordPage') }}" class="btn btn-primary">
            Set Your Password
        </a>
    </div>

    <!-- Optional Message -->
    <p class="text-base-content">
        If you have any questions or need assistance, feel free to contact our support team at [Support Email].
    </p>

@endsection