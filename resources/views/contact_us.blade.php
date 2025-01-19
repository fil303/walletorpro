@extends('landing.app')
@section('content')
<div class="relative bg-slate-900 pt-24 pb-12 text-[var(--info)]">
    <div class="container mx-auto px-6">
        <div class="shadow-lg rounded-lg">
            <h1 class="text-3xl font-bold text-[var(--info) mb-4">Contact Us</h1>
            <p class="text-[var(--info) mb-6">
                If you have any questions or need assistance, feel free to reach out to us through the details below.
            </p>

            <!-- Admin Contact Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-6 rounded-lg shadow-sm bg-[var(--primary)]">
                    <h2 class="text-xl font-semibold text-[var(--info)">Email</h2>
                    <p class="text-[var(--info) mt-2">
                        <a href="mailto:admin@example.com" class="text-blue-500 hover:underline">{{ $app->app_email ?? '' }}</a>
                    </p>
                </div>
                <div class="p-6 rounded-lg shadow-sm bg-[var(--primary)]">
                    <h2 class="text-xl font-semibold text-[var(--info)">Phone</h2>
                    <p class="text-[var(--info) mt-2">
                        <a href="tel:+123456789" class="text-blue-500 hover:underline">{{ $app->app_phone ?? '' }}</a>
                    </p>
                </div>
                <div class="p-6 rounded-lg shadow-sm bg-[var(--primary)]">
                    <h2 class="text-xl font-semibold text-[var(--info)">Address</h2>
                    <p class="text-[var(--info) mt-2">
                        {{ $app->app_address ?? '' }}
                    </p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="p-6 rounded-lg shadow-sm bg-[var(--primary)]">
                <h2 class="text-xl font-semibold text-[var(--info) mb-4">Send Us a Message</h2>
                <form action="{{ route('contact_us') }}" method="POST" class="space-y-4">@csrf
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-[var(--info)">Your Name</label>
                            <input type="text" id="name" name="name" class="bg-slate-900 w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-[var(--info)">Your Email</label>
                            <input type="email" id="email" name="email" class="bg-slate-900 w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" required>
                        </div>
                    </div>
                     <div>
                        <label for="email" class="block text-sm font-medium text-[var(--info)">Subject</label>
                        <input type="text" id="subject" name="subject" class="bg-slate-900 w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-[var(--info)">Message</label>
                        <textarea id="message" name="message" rows="4" class="bg-slate-900 w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" required></textarea>
                    </div>
                    <div>
                        @if($app->app_recaptcha_status ?? '0')
                            <!-- Google reCaptcha V2 Button -->
                            <div class="form-control mt-4">
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                    </div>
                    <div>
                        <button type="submit" class="px-6 w-full py-2 bg-blue-700 font-medium rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
