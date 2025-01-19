@extends('emails.layout.'. ($template ?? 'classic'))
@section('title', __('Test Email'))
@section('header', __('Test Email'))

@section('content')

    <h2 class="text-2xl font-bold mb-4">Test Email!</h2>
    <p class="text-base-content mb-4">
        This is test email
    </p>

@endsection