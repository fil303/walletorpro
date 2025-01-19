@extends('emails.layout.'. ($template ?? 'classic'))
@section('title',  $mailSubject ?? '')
@section('header', $mailSubject ?? '')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Hello, Admin</h2>
    <p>You have received a new message from the Contact Us form on your website.</p>

    <p>
        Details of the submission:    <br/>
        - Name   : {{ $mailName ?? '' }}  <br/>
        - Email  : {{ $mailFrom }}    <br/>
        - subject: {{ $mailSubject }} <br/>
        - Message: <p> {{ $mailMessage ?? '' }} </p>
    </p>
@endsection