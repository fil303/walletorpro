@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Email Verification'))
@section('header', __('Email Verification'))

@section('content')

    <h2 class="text-2xl font-bold mb-4">Hello, {{ $user->name }}!</h2>
    <p class="text-base-content mb-4">
        Thank you for joining {{ $app->app_name ?? 'company'}}! We’re thrilled to have you with us. To get started, please verify your email by clicking the button below:
    </p>
    
    <div class="text-center my-6">
        <a href="{{ $url ?? '#' }}" class="btn btn-primary">
            Verify Your Email
        </a>
    </div>

    <p class="text-base-content">
        If you have any questions or need help, feel free to contact our support team at {{ $app->app_email ?? '' }}.
    </p>

@endsection
