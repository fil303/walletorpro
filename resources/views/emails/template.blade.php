@extends('emails.layout.'. ($template ?? 'classic'))
@section('title',  $mailSubject ?? '')
@section('header', $mailSubject ?? '')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Hello, Admin</h2>
    <p>{{ $mailMessage ?? '' }}</p>
@endsection