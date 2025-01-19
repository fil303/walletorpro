@extends('landing.app')
@section('content')
<div class="relative bg-slate-900 pt-24 pb-12 text-[var(--info)]">
    <div class="container mx-auto px-6">
        {!! $content ?? '' !!}
    </div>
</div>
@endsection